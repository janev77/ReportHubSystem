import { useEffect, useState } from 'react'
import Feed from './components/Feed.jsx'

// For Docker Compose (different ports), set VITE_LOGIN_URL as build arg.
// For K8s (same domain via Ingress), falls back to current origin + /login.
const LOGIN_URL = import.meta.env.VITE_LOGIN_URL || (window.location.origin + '/login')

export default function App() {
  const [token, setToken] = useState(null)
  const [user, setUser] = useState(null)
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    const params = new URLSearchParams(window.location.search)
    const urlToken = params.get('token')

    if (urlToken) {
      localStorage.setItem('api_token', urlToken)
      params.delete('token')
      const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '')
      window.history.replaceState({}, '', newUrl)
      setToken(urlToken)
    } else {
      const stored = localStorage.getItem('api_token')
      if (stored) setToken(stored)
    }

    setLoading(false)
  }, [])

  useEffect(() => {
    if (!token) return

    fetch('/api/user', {
      headers: { Authorization: `Bearer ${token}` },
    })
      .then((res) => {
        if (!res.ok) {
          localStorage.removeItem('api_token')
          window.location.href = LOGIN_URL
          return
        }
        return res.json()
      })
      .then((data) => data && setUser(data))
      .catch(() => {
        localStorage.removeItem('api_token')
        window.location.href = LOGIN_URL
      })
  }, [token])

  const handleLogout = async () => {
    await fetch('/api/logout', {
      method: 'POST',
      headers: { Authorization: `Bearer ${token}` },
    }).catch(() => {})

    localStorage.removeItem('api_token')
    window.location.href = LOGIN_URL
  }

  if (loading) return null

  if (!token) {
    window.location.href = LOGIN_URL
    return null
  }

  return <Feed token={token} user={user} onLogout={handleLogout} />
}
