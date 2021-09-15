export default class ServerConnect {
    static url = 'http://badda3mon.beget.tech/ios-druzhina/API/';

    static async getInfoRoom(room){
        return await fetch(this.url + 'room.php?ROOM=' + room);
    }

}