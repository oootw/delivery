import { Text, View, StyleSheet, ActivityIndicator } from "react-native";
import axios from "axios";
import { useQuery } from "@tanstack/react-query";
import { useEffect } from "react";

const api = axios.create({
  baseURL: "https://127.0.0.1:8000/api/v1",
  withCredentials: true,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

export default function Index() {
  const categoriesResponse = useQuery({
    queryKey: ["menu-categories"],
    queryFn: () => api.get<{ categories: string[] }>("/menu-categories"),
    retry: false,
  });

  useEffect(() => {
    if (categoriesResponse) {
      console.log(categoriesResponse);
    }
  }, [categoriesResponse]);

  return (
    <View>
      <Text>Hello World</Text>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    alignItems: "center",
    justifyContent: "center",
  },
});
