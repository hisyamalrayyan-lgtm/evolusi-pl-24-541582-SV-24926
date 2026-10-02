<template>
  <div style="padding:24px;max-width:800px;margin:0 auto;">
    <h1 style="color:#2d6a4f;margin-bottom:20px;">Daftar Tugas</h1>

    <div v-if="loading" style="color:#888;text-align:center;padding:40px;">
      Memuat data...
    </div>

    <div v-else-if="error" style="color:#c62828;background:#ffebee;padding:16px;border-radius:8px;">
      ⚠️ Gagal memuat data: {{ error }}
    </div>

    <div v-else>
      <p style="color:#555;margin-bottom:16px;">Total: {{ tugas.length }} tugas</p>
      <div v-if="tugas.length === 0" style="color:#888;">Belum ada tugas.</div>
      <div
        v-for="item in tugas"
        :key="item.id"
        style="background:white;border-radius:8px;padding:16px;margin-bottom:12px;box-shadow:0 1px 3px rgba(0,0,0,0.1);"
      >
        <div style="display:flex;justify-content:space-between;align-items:center;">
          <h3 style="color:#1b4332;">{{ item.judul }}</h3>
          <span
            :style="{
              background: item.status === 'selesai' ? '#d8f3dc' : '#fff3bf',
              color: item.status === 'selesai' ? '#1b4332' : '#856404',
              padding:'4px 10px',
              borderRadius:'12px',
              fontSize:'0.85rem',
              fontWeight:'600',
            }"
          >
            {{ formatStatus(item.status) }}
          </span>
        </div>
        <p v-if="item.deskripsi" style="color:#666;margin-top:8px;font-size:0.95rem;">{{ item.deskripsi }}</p>
        <p style="color:#aaa;font-size:0.8rem;margin-top:8px;">{{ formatDate(item.created_at) }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { formatStatus, formatDate } from '../utils/tugas'

const tugas = ref([])
const loading = ref(true)
const error = ref(null)

const apiUrl = import.meta.env.VITE_API_URL

onMounted(async () => {
  try {
    const response = await fetch(`${apiUrl}/api/tugas`)
    if (!response.ok) throw new Error(`HTTP ${response.status}`)
    tugas.value = await response.json()
  } catch (e) {
    error.value = e.message
  } finally {
    loading.value = false
  }
})
</script>
