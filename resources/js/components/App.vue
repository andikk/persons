<template>
  <div class="page" v-bind:class="{page__overlay: showModalAdd||showModalEdit}">
    <h1>Список сотрудников</h1>
    <button class="btn" @click="toggleModalAdd">Добавить</button>
    
    <div class="page__sort">
      <p>Сортировка 
        <select v-model="sortParam">
          <option selected value="name">Имя</option>
          <option value="date">Дата</option>
        </select> 
      </p>
       
    </div>
    
    
    <table class="table">
      <tr>
        <td><a @click="sortParam='name'">Имя</a></td>
        <td><a @click="sortParam='date'">Дата</a></td>
        <td>Действие</td>
      </tr>
      <div class="page__loading" v-if="loading">Загружаю список...</div>
      <tr v-for="(person, index) in sortedList">
        <td>{{ person.name }}</td>
        <td>{{ new Date(person.date) | dateFormat('DD.MM.YYYY')}}</td>

        <td>
          <button class="btn btn--edit" @click="edit(person.id, person.name, person.date)">Править</button>
          <button class="btn btn--del" @click="del(person.id)">Удалить</button> 
        </td>
      </tr>

    </table>

    <div v-show="showInfo" class="page__info">
      <p class="page__message">{{ message }}</p>
    </div>

    <app-modal-add  
      :showModalAdd = "showModalAdd"
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
        sortParam: 'name',
        showInfo: false,
        message: ''
      };
    },
    methods: {
      loadList() {
        axios
        .get('/list/')
        .then(response => {
          this.persons = response.data.persons; 
        })
        .catch(error => {
          this.showMessage("Ошибка при загрузки перечня сотрудников");
          console.log(error);
          this.errored = true;
        })
        .finally(() => (this.loading = false));
      },

      showMessage(message) {
        this.message = message;
        this.showInfo = true;
        setTimeout(() => this.showInfo = false, 3000);
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
        this.showMessage('Добавлено');
      },

      edited() {
        this.loadList();
        this.toggleModalEdit();
        this.showMessage('Изменения внесены');
      },

      edit(persId, persName, persDate) {
        this.persIdEdit = persId;
        this.persNameEdit = persName;
        this.persDateEdit = persDate;
        this.toggleModalEdit();
      },

      del(persId) {
         const url = '/delete/' + persId;
         axios
          .post(url)
          .then(response => {
            this.loadList(); 
            this.showMessage('Запись уадалена');
          })
          .catch(error => {
            this.showMessage("Ошибка при удалении записи");
            console.log(error);
            this.errored = true;
          });      
      },     
    },

    mounted() {
      this.loadList(); 
    },

    computed: {
      sortedList() {
        const sortByName = (d1, d2) => ((d1.name.toLowerCase() > d2.name.toLowerCase()) ? 1 : -1);
        const sortByDate = (d1, d2) => ((d1.date > d2.date) ? 1 : -1);
        
        switch (this.sortParam) {
          case 'name': return this.persons.sort(sortByName);
          case 'date': return this.persons.sort(sortByDate);
          default: return this.persons;
        }
      },
    },

    components: {
      appModalEdit: ModalEdit,
      appModalAdd: ModalAdd
    }
  }
  
</script>