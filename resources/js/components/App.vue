<template>
  <div>
    <h1>Список сотрудников</h1>
    <button @click="add">Добавить</button>
    
    <table>
      <tr>
        <td>Имя</td>
        <td>Дата</td>
        <td>Действие</td>
      </tr>
      <div class="loading" v-show="loading">Загружаю список...</div>
      <tr v-for="(person, index) in persons">
        <td>{{ person.name }}</td>
        <td>{{ person.date }}</td>

        <td>
          <button @click="edit(person.id)">Править</button>
          <button @click="del(person.id)">Удалить</button> 
        </td>
      </tr>

    </table>

    <app-modal-add :showModalAdd="showModalAdd" @added="upadateListAdd"></app-modal-add>


  </div>
 
</template>

<script>
  import axios from 'axios';
  import ModalEdit from './ModalEdit.vue';
  import ModalAdd from './ModalAdd.vue';
  
  export default {
    data() {
      return {
        persons: [],
        loading: true,
        errored: false,
        showModalAdd: false,
        showModalEdit: false,
      };
    },
    methods: {
      loadList() {
        axios
        .get('http://localhost:8000/page/')
        .then(response => {
          this.persons = response.data.persons; 
          console.log(this.persons);
        })
        .catch(error => {
          console.log(error);
          this.errored = true;
        })
        .finally(() => (this.loading = false));
      },
      
      add() {
        //this.showModalAdd=!this.showModalAdd;

        this.showModalAdd = true;
        console.log(this.showModalAdd);
      },

      edit() {
        this.showModalEdit=!this.showModalEdit;
      },

      upadateListAdd() {
        this.loadList();
        //this.showModalAdd = false;
      },

      del(persId) {
         const url = 'http://localhost:8000/delete/' + persId;
         axios
          .post(url)
          .then(response => {
            this.loadList(); 
            console.log('удалено');
          })
          .catch(error => {
            console.log(error);
            this.errored = true;
          })
          .finally(() => (this.loading = false));
      },     
    },

    mounted() {
      this.loadList(); 
    },

    components: {
      appModalEdit: ModalEdit,
      appModalAdd: ModalAdd
    },
  }
  
</script>