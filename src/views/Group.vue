<template>
  <div class="about">
    <h1>Groups</h1>

    <div>
      <form @submit.prevent="addGroup">
        <input type="text" v-model="group_name" >
        <button type="submit">Add Group</button>
      </form>

    </div>
    <div style="text-align: center">
      <ul style="min-width: 400px; max-width: 100%; display: inline-block">
        <li v-for="grp in groups" style="display: flex; justify-content: space-between">
          <span>{{ grp.name}}</span>
          <button @click="deleteGroup(grp.id)">&times;</button>
        </li>
      </ul>
    </div>

  </div>
</template>

<script>
  import axios from "../store/axios";

  export default {
    data(){
      return {
        group_name: '',
        groups: []
      }
    },
    created( ){
      this.loadGroups();
    },
    methods:{
      loadGroups(){
        axios().get('/groups')
          .then( ({data}) => {
            this.groups = data.groups;
          })
      },
      addGroup(){

        axios().post('/groups', {name: this.group_name})
          .then( ({data}) => {
            this.loadGroups( );
          })

      },
      deleteGroup( groupId ){
        alert( groupId );
      }
    }
  }

</script>
