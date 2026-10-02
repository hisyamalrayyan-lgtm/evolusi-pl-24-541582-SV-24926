/**
 * Format status tugas menjadi label yang lebih ramah pengguna.
 * @param {string} status - 'pending' atau 'selesai'
 * @returns {string}
 */
export function formatStatus(status) {
  const map = {
    pending: 'Pending',
    selesai: 'Selesai',
  }
  return map[status] ?? status
}

/**
 * Format tanggal ke format lokal Indonesia.
 * @param {string} dateString
 * @returns {string}
 */
export function formatDate(dateString) {
  if (!dateString) return '-'
  return new Date(dateString).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
}
