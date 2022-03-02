<template>
    <div>
        <div>
            <h2>チャット</h2>
            <ul>
                <li v-for="message in messages">
                    {{ Message['message'] }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    deta() {
        return {
            messages : [],
            newMessage : ''
        }
    },
    mounted(){
        axios.get("/api/messages").then(response => (this.messages = response.data));
    },
    methods:{
        addMessage() {
            axios.post('/api/messages', {
                name : this.newMessage
            })
            .then(response => this.messages.push(response.data));

        this.newMessage = '';
        }
    }
}
</script>

