import { describe, it, expect } from 'vitest'
import { formatStatus, formatDate } from '../utils/tugas'

describe('formatStatus', () => {
  it('mengembalikan "Selesai" untuk status selesai', () => {
    expect(formatStatus('selesai')).toBe('SALAH')
  })

  it('mengembalikan "Pending" untuk status pending', () => {
    expect(formatStatus('pending')).toBe('Pending')
  })

  it('mengembalikan nilai asli jika status tidak dikenal', () => {
    expect(formatStatus('unknown')).toBe('unknown')
  })
})

describe('formatDate', () => {
  it('mengembalikan "-" jika dateString kosong', () => {
    expect(formatDate('')).toBe('-')
    expect(formatDate(null)).toBe('-')
    expect(formatDate(undefined)).toBe('-')
  })

  it('mengembalikan string tanggal yang valid', () => {
    const result = formatDate('2026-01-15T00:00:00.000Z')
    expect(typeof result).toBe('string')
    expect(result.length).toBeGreaterThan(0)
  })
})
