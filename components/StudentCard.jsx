import React, {useEffect, useState} from 'react';
import {View, Text, StyleSheet, Dimensions, Pressable, Alert,Slider } from "react-native";
import {CheckBox, Input, LinearProgress} from "react-native-elements";

const StudentCard = ({navigation, currentStudent}) => {
    const {width} = Dimensions.get("window");

    useEffect(()=>console.log(currentStudent),[])

    return (
        <View style={{...styles.card, width}}>
            <View style={{width: width-10}}>
                <View style={{display: "flex", flexDirection: "row", marginBottom: 5}}>
                    <View style={{width: width * 36 / 100}}></View>
                    <View style={{display: "flex"}}>
                        <View>
                            <Text style={{fontSize: 25, width: 230, marginBottom: 5}}>{currentStudent.NAME}</Text>
                            <Text style={{
                                fontSize: 15,
                                marginBottom: 5
                            }}>{currentStudent.PHONE_NUMBER[0] === '+' ? currentStudent.PHONE_NUMBER : `+${currentStudent.PHONE_NUMBER}`}</Text>
                        </View>
                        <View style={{display: "flex", flexDirection: 'row'}}>
                            <CheckBox title={"БРСМ"} checked={+currentStudent.BRSM} containerStyle={styles.checkBox}/>
                            <CheckBox title={"Профсоюз"} checked={+currentStudent.TRADE_UNION}
                                      containerStyle={styles.checkBox}/>
                        </View>
                        <View style={{display: "flex", flexDirection: 'row', marginTop: 20}}>
                            <CheckBox title={"Работа"} checked={+currentStudent.WORKING} containerStyle={styles.checkBox}/>
                            <CheckBox title={"Бюджет"} checked={+currentStudent.EDUCATION_TYPE}
                                      containerStyle={styles.checkBox}/>
                        </View>
                    </View>
                </View>
                <View>
                    <Text style={styles.block}>Факультет: {currentStudent.FACULTY} | {currentStudent.GROUP_ID}</Text>
                    <Text style={styles.block}>Дата рождения: {currentStudent.DATE_BIRTH.split('-').reverse().join('.')}</Text>
                    <Text style={styles.block}>Льготы: {currentStudent.PRIVILEGIES}</Text>
                    <Text style={styles.block}>Домашний адрес: {currentStudent.HOME_ADRESS}</Text>
                    <Text style={styles.block}>Домашний номер: {currentStudent.HOME_NUMBER}</Text>
                    <Text style={styles.block}>Мать: {currentStudent.MOTHER_INFO}</Text>
                    <Text style={styles.block}>{currentStudent.MOTHER_NUMBER}</Text>
                    <Text style={styles.block}>Отец: {currentStudent.FATHER_INFO}</Text>
                    <Text style={styles.block}>{currentStudent.FATHER_NUMBER}</Text>
                    <Text style={styles.block}>Увлечения: {currentStudent.HOBBIES}</Text>
                    <View>
                        <Text style={{textAlign:'center'}}>Отработано {currentStudent.HOUR_WORKING*2} час(-а/-ов)</Text>
                        <Slider
                            disabled={true}
                            minimumValue={0}
                            maximumValue={10}
                            value={currentStudent.HOUR_WORKING}
                        />
                    </View>
                    <View>
                        <Text style={{textAlign:'center'}}>Оплачено {currentStudent.PAID_MONTH} месяца(-ев)</Text>
                        <Slider
                            disabled={true}
                            minimumValue={0}
                            maximumValue={10}
                            value={currentStudent.PAID_MONTH}
                        />
                    </View>
                </View>
            </View>
        </View>
    )
};

const styles = StyleSheet.create({
    card: {
        flex: 1,
        alignItems: 'center',
    },
    checkBox: {
        backgroundColor: "rgba(255,255,255,0)",
        borderWidth: 0,
        margin: 0,
        padding: 0,
        width: 93
    },
    block: {
        fontSize: 15,
        marginBottom: 5
    }
})

export default StudentCard;