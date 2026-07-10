import { StyleSheet } from "react-native";

type fn = <T extends StyleSheet.NamedStyles<T>>(styles: T) => T;

export const cs: fn = (styles) => StyleSheet.create(styles);
