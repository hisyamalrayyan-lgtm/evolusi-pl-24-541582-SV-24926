<template>
  <div id="app">
    <nav style="background:#2d6a4f;padding:12px 24px;display:flex;gap:20px;align-items:center;">
      <span style="color:white;font-weight:bold;font-size:1.1rem;">📋 Tugas App</span>
      <router-link to="/" style="color:#b7e4c7;text-decoration:none;">Home</router-link>
      <router-link to="/about" style="color:#b7e4c7;text-decoration:none;">About</router-link>
    </nav>
    <router-view />
  </div>
</template>

<script setup>
</script>

<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: sans-serif; background: #f5f5f5; }
</style>
