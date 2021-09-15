import React, {useEffect, useState} from 'react';
import {StyleSheet, View, Text, ScrollView, Dimensions, Pressable, FlatList} from "react-native";
import StudentCard from "../components/StudentCard";
import {LinearProgress} from "react-native-elements";

const ResultSearch = ({navigation, route}) => {
    const [loading, setLoading] = useState(false)

    useEffect(()=>{
        setLoading(false);
        navigation.setOptions({title: route.params.searchValue});
    },[])

    useEffect(()=>{
        if(route.params.students.length){
            setLoading(true);
        }
    },[route.params.students.length])

    const {width} = Dimensions.get("window");


    return (
        <View style={styles.container}>
            <ScrollView pagingEnabled={true} horizontal={true} style={{width}}>
                {loading ? route.params.students.map((el,index)=>(
                    // <Pressable
                    //     onLongPress={()=>navigation.navigate("StudentEdit", {
                    //         body: el,
                    //     })}
                    //     key={index}
                    // >
                    //     <StudentCard body={el}/>
                    // </Pressable>
                    <StudentCard currentStudent={el} key={index}/>
                )) : null}
            </ScrollView>
        </View>
    );
};

const styles = StyleSheet.create({
    container: {
        flex: 1,
        justifyContent: 'center',
        alignItems: 'center',
        padding: 15,
        backgroundColor: 'rgb(255,255,255)',
    }
})

export default ResultSearch;