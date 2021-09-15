import React, {useEffect, useState} from 'react';
import {
    ImageBackground,
    Keyboard,
    KeyboardAvoidingView,
    Platform,
    StyleSheet,
    Text,
    TouchableWithoutFeedback,
    View
} from 'react-native';
import {SearchBar, Button, Switch} from "react-native-elements";
import {useFetching} from "../hooks/useFetching";
import ServerConnect from "../API/ServerConnect";

const Home = ({navigation}) => {
    const [searchValue, setSearchValue] = useState('');
    const [settingSearch, setSettingSearch] = useState(false);
    const [errorInput, setErrorInput] = useState(false);

    //todo settingsSearch
    // useEffect(()=>{
    //     if(settingSearch){
    //         const regex = new RegExp("^([A-zА-яЁё]+|\s+)$");
    //         setErrorInput(regex.test(searchValue));
    //     }else{
    //         const regex = new RegExp("^(\d)$")
    //         setErrorInput(regex.test(searchValue))
    //     }
    // },[searchValue, settingSearch])

    useEffect(()=>{
        setSearchValue('');
    },[]);

    const [students, loading, error] = useFetching(async () => {
        await ServerConnect.getInfoRoom(searchValue)
            .then(response => response.json())
            .then(students => {
                navigation.navigate('ResultSearch', {
                    settingSearch: settingSearch ? 'room' : 'student',
                    searchValue: searchValue,
                    students: students,
                })
            })
            .catch(error=>console.log(error))
    })



    return (
        <KeyboardAvoidingView
            behavior={Platform.OS === "ios" ? "padding" : "height"}
            style={styles.container}
        >
            <TouchableWithoutFeedback onPress={Keyboard.dismiss}>
                <View style={styles.container}>

                    <SearchBar
                        placeholder={settingSearch ? "Имя" : "Номер комнаты"}
                        value={searchValue}
                        onChangeText={setSearchValue}
                        lightTheme={true}
                        platform={'ios'}
                        cancelButtonTitle={'Отмена'}
                    />
                    {loading ? <Text>Загрузка</Text> : null}
                    <View style={{
                        flexDirection: 'row',
                        alignItems: 'center',
                        justifyContent: 'space-between',
                        width: 250,
                        marginVertical: 10
                    }}>
                        <Text style={{fontSize: 17, color: 'rgba(1, 1, 1, .5)'}}>Поиск по имени</Text>
                        <Switch
                            value={settingSearch}
                            onValueChange={value => setSettingSearch(value)}
                        />
                    </View>
                    <Button
                        title={errorInput ? "Ошибка ввода" : "Поиск"}
                        buttonStyle={{
                            borderColor: 'rgba(78, 116, 289, 1)',
                        }}
                        type="outline"
                        titleStyle={{color: 'rgba(78, 116, 289, 1)'}}
                        containerStyle={{
                            width: 200,
                            marginHorizontal: 50,
                            marginVertical: 10,
                        }}
                        disabled={searchValue != '' ? false : true}
                        onPress={students}
                        loading={loading}
                    />
                </View>
            </TouchableWithoutFeedback>
        </KeyboardAvoidingView>

        // onPress={()=>navigation.navigate('ResultSearch',{
        //     settingSearch: settingSearch ? 'room' : 'student',
        //     searchValue: searchValue
        // })}
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

export default Home;