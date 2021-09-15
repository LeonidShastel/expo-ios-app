import React from 'react';
import {View, StyleSheet, Text} from "react-native";

const StudentEdit = ({navigation, route}) => {
    return (
        <View style={styles.container}>
            <Text>{route.params.body}</Text>
        </View>
    );
};

const styles = StyleSheet.create({
    container: {
        flex: 1,
        alignItems: 'center',
        justifyContent: 'center'
    }
})

export default StudentEdit;