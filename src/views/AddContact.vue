<template>
    <div class="login">

        <div>

            <h1>Add Contact</h1>
            <form class="form login-form" action="" method="post" @submit.prevent="submit">

                <div class="input-item">
                    <label for="name">Name</label>
                    <input type="text" v-model="formData.name" id="name">
                </div>

                <div class="input-item">
                    <label for="phones">Phone Numbers (comma separated)</label>
                    <textarea v-model="phones" id="phones"></textarea>
                </div>

                <div class="input-item">
                    <label for="emails">Email Addresses (comma separated)</label>
                    <textarea v-model="emails" id="emails"></textarea>
                </div>


                <div class="input-item">
                    <div style="display: flex; margin-bottom: 10px">
                      <div v-for="grp in selectedGroups" style="margin-right: 4px; border: 1px solid green; padding: 2px">
                          {{ grp.name}}
                      </div>
                    </div>
                    <label for="groups">Select Group</label>
                    <select id="groups" @change="updateSelectedGroup" v-model="selectedGroupId">
                        <option value="">--select--</option>
                        <option v-for="grp in groups" :value="grp.id">{{ grp.name}}</option>
                    </select>
                </div>


                <div class="input-item">
                    <button type="submit" class="btn">Submit</button>
                </div>


            </form>
        </div>
    </div>
</template>

<script>

    import axios from "../store/axios";

    export default {
        components: {},
        data() {
            return {
                selectedGroups: [ ],
                selectedGroupId: { },
                groups: [ ],
                phones: '',
                emails: '',
                formData: {
                    name: '',
                    emails: [],
                    phones: [],
                    groups: [],
                }
            }
        },
        created(){
            axios().get('/groups')
                .then( ({data}) => {
                    this.groups = data.groups;
                })
        },
        methods: {
            submit() {
                this.formData.emails = this.emails.split(',');
                this.formData.phones = this.phones.split(',');
                this.formData.groups = this.selectedGroups.map( item => item.id );


                console.log( this.formData );

                axios().post('/contacts', this.formData )
                    .then( ({data}) => this.$router.push('/') )
                    .catch( err => console.log( err ))

                // console.log( this.selectedGroups.map( item => item.id ) );
            },
            updateSelectedGroup( ){
                if( this.selectedGroupId ) {

                    const groups = this.groups.filter( grp => grp.id == this.selectedGroupId );

                    console.log( groups[0], this.groups, this.selectedGroupId  );

                    if( groups[0] ) {
                        const selectedIndex = this.selectedGroups.indexOf( groups[0] );
                        if( selectedIndex < 0 ) {
                            this.selectedGroups.push( groups[0] );
                        }else {
                            this.selectedGroups.splice( selectedIndex, 1 )
                        }
                    }
                }
            },
        }

    }

</script>

<style scoped>

    .login {
        display: flex;
        justify-content: center;
    }

    .form {
        text-align: left;
    }

    .login-form {
        width: 400px;
    }

    .input-item {
        margin-bottom: 10px;
    }

    .login .input-item input ,
    .login .input-item textarea,
    .login .input-item select {
        width: 100%;
        padding: 8px 10px;
    }

    .btn {
        padding: 10px 20px;
        background: #2c3e50;
        color: #FFF;
        cursor: pointer;
    }


    .input-item label {
        display: block;
    }

</style>
