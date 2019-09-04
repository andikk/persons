<template>
  <div class="modal" v-bind:class="{active: showModal}">
    <button class="modal__close" @click="close">&times;</button>

    <slot></slot>

  </div>  
</template>

<script>
  
  export default {

    methods: {
      close() {
        this.$emit('close');
      }
    },
    props: ['showModal']
  }  
</script>

<style>
  .modal {
    position: fixed;
    top: 40px;
    left: 50%;
    transform: translateX(-50%);
    display: none;
    width: 300px;
    padding: 30px;
    border-radius: 4px;
    background-color: #fff;
    text-align: center; 
  } 

  .modal.active {
    display: block;
    z-index: 2;
  }

  .modal__close {
    position: absolute;
    right: 10px;
    top: 10px;
    border: none;
    font-size: 24px;
    background-color: transparent;
    color: #42b983;
  }
  
</style>
