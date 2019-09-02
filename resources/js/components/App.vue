<template>
  <div>
    <h1>Список сотрудников</h1>
    <button @click="toggleModalAdd">Добавить</button>
    
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
          <button @click="edit(person.id, person.name, person.date)">Править</button>
          <button @click="del(person.id)">Удалить</button> 
        </td>
      </tr>

    </table>

    <app-modal-add v-bind:class="{active: showModalAdd}" 
      @added="added" 
      @closed="toggleModalAdd">
    </app-modal-add>

    <app-modal-edit
      :showModalEdit = "showModalEdit" 
      :persIdEdit="persIdEdit"
      :persNameEdit="persNameEdit"
      :persDateEdit="persDateEdit"
      @edited="edited" 
      @closed="toggleModalEdit">
    </app-modal-edit>


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
        persIdEdit: '',
        persNameEdit: '',
        persDateEdit: '',
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
      
      toggleModalAdd() {
        this.showModalAdd=!this.showModalAdd;
      },

      toggleModalEdit() {
        this.showModalEdit=!this.showModalEdit;
      },

      added() {
        this.loadList();
        this.toggleModalAdd();
        console.log('Добавлено');
      },

      edited() {
        this.loadList();
        this.toggleModalEdit();
        console.log('Изменено');
      },

      edit(persId, persName, persDate) {
        this.persIdEdit = persId;
        this.persNameEdit = persName;
        this.persDateEdit = persDate;
        this.toggleModalEdit();
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