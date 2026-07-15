#!/usr/bin/env python3

from __future__ import annotations

import json
import urllib.request

from ansible.errors import AnsibleParserError
from ansible.plugins.inventory import BaseInventoryPlugin
from ansible.utils.display import Display


display = Display()


DOCUMENTATION = r"""
name: control_plane
plugin_type: inventory
short_description: Dynamic inventory from delivery control-plane
description:
  - Загружает список data-plane серверов из control-plane API.
options:
  plugin:
    description: Token that ensures this is a source file for the plugin.
    required: true
    choices: ["control_plane"]
  control_plane_url:
    description: Base URL of control-plane API.
    type: str
    required: true
  api_token:
    description: Optional bearer token for control-plane API.
    type: str
    required: false
"""


class InventoryModule(BaseInventoryPlugin):
    NAME = "control_plane"

    def verify_file(self, path: str) -> bool:
        return super().verify_file(path) and path.endswith(("control_plane.yml", "control_plane.yaml"))

    def parse(self, inventory, loader, path, cache=True):
        super().parse(inventory, loader, path, cache)

        self._read_config_data(path)
        control_plane_url = self.get_option("control_plane_url")
        api_token = self.get_option("api_token")

        if not control_plane_url:
            raise AnsibleParserError("control_plane_url обязателен для inventory plugin control_plane")

        endpoint = control_plane_url.rstrip("/") + "/v1/servers"
        req = urllib.request.Request(endpoint)
        if api_token:
            req.add_header("Authorization", f"Bearer {api_token}")

        try:
            with urllib.request.urlopen(req, timeout=10) as response:
                payload = json.loads(response.read().decode("utf-8"))
        except Exception as exc:  # noqa: BLE001
            display.warning(f"Не удалось загрузить inventory из control-plane: {exc}. Используется статический inventory.")
            return

        servers = payload.get("servers")
        if not isinstance(servers, list):
            raise AnsibleParserError("control-plane /v1/servers вернул невалидный payload")

        self.inventory.add_group("dataplane")
        self.inventory.add_group("canary")
        self.inventory.add_group("production")

        for item in servers:
            if not isinstance(item, dict):
                continue

            hostname = str(item.get("hostname", "")).strip()
            if not hostname:
                continue

            ansible_host = str(item.get("ansible_host", "")).strip() or hostname
            group = str(item.get("group", "production")).strip()
            if group not in ("canary", "production"):
                group = "production"

            self.inventory.add_host(hostname, group="dataplane")
            self.inventory.add_host(hostname, group=group)
            self.inventory.set_variable(hostname, "ansible_host", ansible_host)

            for key in ("owner_slug", "owner_id", "workspace_id", "server_domain", "pinned_ref"):
                if key in item:
                    self.inventory.set_variable(hostname, key, item[key])

