import {
  ImageStyle,
  Pressable,
  PressableProps,
  StyleSheet,
  Text,
  TextStyle,
  ViewStyle,
} from "react-native";
import { tokens } from "../tokens/colors";
import { cs } from "../utils";
import { useMemo } from "react";

type ButtonType = "button" | "chip" | "icon" | "nav-menu";
type ButtonVariant = "accent" | "neutral" | "danger" | "alert" | "success";
type ButtonSize = "s" | "m" | "l";
type ButtonShape = "square" | "cycle";

type ButtonSizeStyle = {
  button: ViewStyle;
  text: TextStyle;
  icon: ImageStyle;
};

type ButtonShapeStyle = {
  button: {
    borderRadius: number;
  };
};

type ButtonVariantStyle = {
  buttonContainer: {
    backgroundColor: string;
  };
  text: {
    color: string;
  };
};

const getButtonSize = (size: ButtonSize): ButtonSizeStyle => {
  switch (size) {
    case "s":
      return cs<ButtonSizeStyle>({
        button: {
          paddingHorizontal: 12,
          paddingVertical: 9,
          gap: 4,
        },
        text: {
          fontSize: 14,
          fontWeight: "500",
          letterSpacing: -0.5,
        },
        icon: {
          width: 16,
          height: 16,
        },
      });
    case "m":
      return cs<ButtonSizeStyle>({
        button: {
          paddingHorizontal: 14,
          paddingVertical: 12,
          gap: 6,
        },
        text: {
          fontSize: 16,
          fontWeight: "600",
          letterSpacing: -0.5,
        },
        icon: {
          width: 20,
          height: 20,
        },
      });
    case "l":
      return cs<ButtonSizeStyle>({
        button: {
          paddingHorizontal: 16,
          paddingVertical: 17,
          gap: 8,
        },
        text: {
          fontSize: 18,
          fontWeight: "600",
          letterSpacing: -0.5,
        },
        icon: {
          width: 22,
          height: 22,
        },
      });
  }
};

const getButtonShape = (shape: ButtonShape): ButtonShapeStyle => {
  switch (shape) {
    case "square":
      return cs<ButtonShapeStyle>({
        button: {
          borderRadius: 20,
        },
      });
    case "cycle":
      return cs<ButtonShapeStyle>({
        button: {
          borderRadius: 999,
        },
      });
  }
};

const getButtonVariant = (
  variant: ButtonVariant,
  isPressed: boolean,
  isDisabled: boolean,
): ButtonVariantStyle => {
  if (isDisabled) {
    return cs<ButtonVariantStyle>({
      buttonContainer: {
        backgroundColor: tokens.controlDisabled,
      },
      text: {
        color: tokens.contentOncontrolDisabled,
      },
    });
  }

  if (isPressed) {
    switch (variant) {
      case "accent":
        return cs<ButtonVariantStyle>({
          buttonContainer: {
            backgroundColor: tokens.controlAccentPrimaryPressed,
          },
          text: {
            color: tokens.contentInvertedPrimary,
          },
        });
      case "success":
        return cs<ButtonVariantStyle>({
          buttonContainer: {
            backgroundColor: tokens.controlSuccesPrimaryPressed,
          },
          text: {
            color: tokens.contentInvertedPrimary,
          },
        });
      case "neutral":
        return cs<ButtonVariantStyle>({
          buttonContainer: {
            backgroundColor: tokens.neutral700,
          },
          text: {
            color: tokens.contentInvertedPrimary,
          },
        });
      case "alert":
        return cs<ButtonVariantStyle>({
          buttonContainer: {
            backgroundColor: tokens.controlAlertPrimaryPressed,
          },
          text: {
            color: tokens.contentOncontrolAlertPrimary,
          },
        });
      case "danger":
        return cs<ButtonVariantStyle>({
          buttonContainer: {
            backgroundColor: tokens.controlDangerPrimaryPressed,
          },
          text: {
            color: tokens.contentInvertedPrimary,
          },
        });
    }
  }

  switch (variant) {
    case "accent":
      return cs<ButtonVariantStyle>({
        buttonContainer: {
          backgroundColor: tokens.controlAccentPrimary,
        },
        text: {
          color: tokens.contentInvertedPrimary,
        },
      });
    case "success":
      return cs<ButtonVariantStyle>({
        buttonContainer: {
          backgroundColor: tokens.controlSuccesPrimary,
        },
        text: {
          color: tokens.contentInvertedPrimary,
        },
      });
    case "neutral":
      return cs<ButtonVariantStyle>({
        buttonContainer: {
          backgroundColor: tokens.neutral800,
        },
        text: {
          color: tokens.contentInvertedPrimary,
        },
      });
    case "alert":
      return cs<ButtonVariantStyle>({
        buttonContainer: {
          backgroundColor: tokens.controlAlertPrimary,
        },
        text: {
          color: tokens.contentOncontrolAlertPrimary,
        },
      });
    case "danger":
      return cs<ButtonVariantStyle>({
        buttonContainer: {
          backgroundColor: tokens.controlDangerPrimary,
        },
        text: {
          color: tokens.contentInvertedPrimary,
        },
      });
  }
};

type Props = {
  title: string;
  type?: ButtonType;
  variant?: ButtonVariant;
  size?: ButtonSize;
  shape?: ButtonShape;
  isDisabled?: boolean;
  onPress?: () => void;
} & Omit<PressableProps, "onPress">;

const Button = ({
  title,
  type = "button",
  variant = "accent",
  size = "m",
  shape = "square",
  isDisabled = false,
  onPress,
  ...props
}: Props) => {
  const sizeStyles = useMemo(() => getButtonSize(size), [size]);
  const shapeStyles = useMemo(() => getButtonShape(shape), [shape]);

  return (
    <Pressable
      {...props}
      onPress={isDisabled ? undefined : onPress}
      disabled={isDisabled}
      style={({ pressed }) => {
        const variantStyles = useMemo(
          () => getButtonVariant(variant, pressed, isDisabled),
          [variant, pressed, isDisabled],
        );

        return [
          sizeStyles.button,
          shapeStyles.button,
          variantStyles.buttonContainer,
        ];
      }}
    >
      {({ pressed }) => {
        const variantStyles = useMemo(
          () => getButtonVariant(variant, pressed, isDisabled),
          [variant, pressed, isDisabled],
        );

        return (
          <Text style={[sizeStyles.text, variantStyles.text]}>{title}</Text>
        );
      }}
    </Pressable>
  );
};

export default Button;
