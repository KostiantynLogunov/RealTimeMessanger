<template>
    <div class="container">
        <h6>by kostyk....</h6>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <textarea rows="6" class="form-control" readonly="">{{ dataMessage.join('\n') }}</textarea>
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
                message: ""
            }
        },
        mounted() {
            var socket = io('http://192.168.10.10:3000');
            socket.on("news-action:App\\Events\\NewMessage", function (data) {
                this.dataMessage.push(data.message);
                // alert(data.result.labels[4]);
            }.bind(this));
        },
        methods: {
            sendMessage: function () {
                axios({
                    method: 'get',
                    url: '/',
                    params: { message: this.message }
                }).then((response) => {
                    this.message = "";
                });
            },
        },
    }
</script>
