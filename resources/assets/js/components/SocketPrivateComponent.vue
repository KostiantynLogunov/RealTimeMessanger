<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="row form-group">
                    <div class="col-sm-4">
                        <select name="" multiple="" class="form-control" v-model="usersSelect">
                            <option v-for="user in users" :value="'news-action.' + user.id">{{ user.email }}</option>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <textarea rows="6" class="form-control" readonly="">{{ dataMessage.join('\n') }}</textarea>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Enter a new message..." v-model="message">
                    <div class="input-group-append">
                        <button @click="sendMessage" class="btn btn-outline-secondary" type="button">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                dataMessage: [],
                message: "",
                usersSelect: []
            }
        },
        props: [
            'users',
            'user'
        ],
        mounted() {
            var socket = io('http://192.168.10.10:3000');
            socket.on("news-action." + this.user.id + ":App\\Events\\PrivateMessage", function (data) {
                this.dataMessage.push(data.message.user + ':' + data.message.message);
                // alert(data.result.labels[4]);
            }.bind(this));
            socket.on("news-action.:App\\Events\\PrivateMessage", function (data) {
                this.dataMessage.push(data.message.user + ':' + data.message.message);
                // alert(data.result.labels[4]);
            }.bind(this));
        },
        methods: {
            sendMessage: function () {
                if (!this.usersSelect.length) {
                    this.usersSelect.push('news-action.');
                }

                axios({
                    method: 'get',
                    url: '/send-private-msg',
                    params: { channels: this.usersSelect,message: this.message, user: this.user.email }
                }).then((response) => {
                    this.dataMessage.push(this.user.email + ':' + this.message);
                    this.message = "";
                });
            },
        },
    }
</script>