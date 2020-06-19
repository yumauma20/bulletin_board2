<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header" v-on:click='ActiveBtn=!ActiveBtn'>サンプルタイトル</div>
            <transition name="menu">
              <div class="card-body" v-show="ActiveBtn">
                <ul class="list">
                  <li v-for="list in lists" v-bind:key="list" class="list-item">
                    <a href="#">{{list}}</a>
                  </li>
                </ul>
              </div>
            </transition>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
  .card-header {
    position: fixed; /*常に最上部に表示したいので固定*/
    top: 0;
    right: 50px;
    width: 70px;
    height: 72px;
    cursor: pointer;
    z-index: 50;
    background-color: blue;
  }
  .card-body {
    background-color: rgba(197, 197, 197, 0.671);
    z-index: 30;
    padding: 2rem 1rem;
    position: fixed;
    width: 20rem;
    height: 80rem;
    top: 0;
    right: 0;
  }
  ul {
    list-style: none;
  }
  .list-item{
    color: red;
    font-size: 25px;
  }
  .menu-enter-active, .menu-leave-active {
    transition: opacity 0.4s;
  }
  .menu-enter, .menu-leave-to {
  opacity: 0;
  }
  .menu-leave, .menu-enter-to{
    opacity: 1;
  }
</style>

<script>
  export default {
    data (){
      return {
        ActiveBtn: false,
        lists : ["sample1","sample2","sample3"]
      }
    }
  } 
</script>
