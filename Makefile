b-up:
	cd backend && docker compose up -d

b-down:
	cd backend && docker compose down

b-logs:
	cd backend && docker compose logs -f

b-bash:
	cd backend && docker compose exec backend bash

b-exec:
	cd backend && docker compose exec backend $(cmd)

f-up:
	cd frontend && pnpm run web