<style scoped>
header {
  box-sizing: border-box;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  height: 3rem;
  line-height: 3rem;
  padding: 0rem 2rem;
  background-color: blueviolet;
  color: rgb(200,200,200);
}
</style>

<template>
  <header>
    <nav>
      <RouterLink to="/login">login</RouterLink>
      <RouterLink to="/home">home</RouterLink>
    </nav>
  </header>

  <RouterView />
</template>

<script>
import { RouterLink, RouterView } from 'vue-router'
</script>
