<template>
    <div class="home">

        <router-link to="add-contact">Add Contact</router-link>

        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th>Phone(s)</th>
                <th>Email(s)</th>
                <th>Group(s)</th>
                <th colspan="5">Action</th>
            </tr>
            </thead>
            <tbody>
                <contact-item @deleted="loadContacts" v-for="contact in contacts" :contact="contact" :key="contact.id"></contact-item>
            </tbody>
        </table>

    </div>
</template>

<script>


    import ContactItem from "./components/contact-item.vue";
    import axios from '../store/axios'

    export default {
        name: 'Home',
        components: {ContactItem},
        data(){
            return {
                contacts: []
            }
        },
        methods: {
            loadContacts(){

                axios().get( '/contacts' )
                    .then( ({data}) => {
                        console.log( data );
                        if( Array.isArray( data.contacts  ) ) {
                            this.contacts = data.contacts;
                        }
                    })
            }
        },
        created(){
            this.loadContacts();
        }

    }
</script>

