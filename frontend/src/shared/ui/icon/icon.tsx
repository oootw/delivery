import type { SvgProps } from "react-native-svg";

import { icons, type IconName } from "./icons";

type IconProps = SvgProps & {
  name: IconName;
  size?: number;
  color?: string;
};

export function Icon({
  name,
  size = 20,
  width,
  height,
  color = "#000",
  fill,
  ...props
}: IconProps) {
  const Svg = icons[name];

  return (
    <Svg
      width={width ?? size}
      height={height ?? size}
      color={fill ?? color}
      {...props}
    />
  );
}
