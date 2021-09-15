import { StatusBar } from 'expo-status-bar';
import React from 'react';
import { StyleSheet, Text, View } from 'react-native';
import {NavigationContainer} from "@react-navigation/native";
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import {SafeAreaProvider} from "react-native-safe-area-context";
import Home from "./screens/Home";
import ResultSearch from "./screens/ResultSearch";
import StudentEdit from "./screens/StudentEdit";

const Stack = createNativeStackNavigator();

export default function App() {

  return (
    <SafeAreaProvider>
      <StatusBar style={"auto"}></StatusBar>
      <NavigationContainer>
        <Stack.Navigator initialRouteName={"Home"}>
          <Stack.Screen name={'Home'} component={Home} options={{title:'Поиск'}}/>
          <Stack.Screen name={'ResultSearch'} component={ResultSearch}/>
          <Stack.Screen name={'StudentEdit'} component={StudentEdit}/>
        </Stack.Navigator>
      </NavigationContainer>
    </SafeAreaProvider>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
    alignItems: 'center',
    justifyContent: 'center',
  },
});
