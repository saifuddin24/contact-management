<template>
    <tr>

        <td>{{contact.name}}</td>

        <td>
            <ul>
                <li v-for="phone in phoneNumbers" :key="phone.id">{{phone.phone_number}}</li>
            </ul>
        </td>
        <td>
            <ul>
                <li v-for="item in emails" :key="item.id">{{item.email}}</li>
            </ul>
        </td>
        <td>
            <ul>
                <li v-for="item in groups" :key="item.id">{{item.name}}</li>
            </ul>
        </td>
        <td>
            <button @click="deleteContact">&times;</button>
        </td>
    </tr>
</template>

<script>
    import axios from "../../store/axios";

    export default {
        name: "contact-item",
        props: { contact: Object },
        computed: {
            emails(){
                return Array.isArray( this.contact.emails ) ? this.contact.emails: []
            },
            phoneNumbers(){
                return Array.isArray( this.contact.phone_numbers ) ? this.contact.phone_numbers: []
            },
            groups(){
                return Array.isArray( this.contact.groups ) ? this.contact.groups: []
            }
        },
        methods: {
            deleteContact(  ){
                if( confirm('Are you sure?') ) {
                    axios().delete( '/contacts/' + this.contact.id )
                        .then( () => this.$emit('deleted') )
                }
            }
        }
    }
</script>

<style scoped>

</style>
