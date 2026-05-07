import { useEffect, useState } from 'react'

export default function Feed({ token, user, onLogout }) {
  const [announcements, setAnnouncements] = useState([])
  const [meta, setMeta] = useState(null)
  const [page, setPage] = useState(1)
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    setLoading(true)

    fetch(`/api/feed?page=${page}`, {
      headers: { Authorization: `Bearer ${token}` },
    })
      .then((res) => res.json())
      .then((data) => {
        setAnnouncements(data.data)
        setMeta(data.meta)
      })
      .finally(() => setLoading(false))
  }, [page, token])

  return (
    <div className="bg-gray-100 min-h-screen">
      <nav className="bg-white shadow px-4 sm:px-6 py-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
        <span className="font-bold text-lg text-center sm:text-left">ReportHubSystem</span>
        <div className="flex flex-col sm:flex-row items-center gap-2 sm:gap-4 text-center sm:text-right">
          <span className="text-sm text-gray-600 break-all">{user?.email}</span>
          <button
            onClick={onLogout}
            className="text-sm text-red-500 hover:underline"
          >
            Одјави се
          </button>
        </div>
      </nav>

      <div className="max-w-3xl mx-auto py-8 sm:py-10 px-4">
        <h1 className="text-xl sm:text-2xl font-bold mb-6">Известувања</h1>

        {loading ? (
          <p className="text-gray-500 text-center">Вчитување...</p>
        ) : announcements.length === 0 ? (
          <p className="text-gray-500 text-center">Нема достапни известувања.</p>
        ) : (
          announcements.map((announcement) => (
            <div key={announcement.id} className="bg-white rounded-xl shadow p-4 sm:p-6 mb-4">
              <div className="flex items-center justify-between mb-2 flex-wrap gap-2">
                <span
                  className={`text-xs font-semibold uppercase tracking-wide ${
                    announcement.status === 'important' ? 'text-red-500' : 'text-gray-400'
                  }`}
                >
                  {announcement.category?.name ?? '-'}
                </span>
                {announcement.is_pinned && (
                  <span className="text-xs text-yellow-500 font-semibold">📌 Pinned</span>
                )}
              </div>

              <h2 className="text-base sm:text-lg font-semibold mb-1">{announcement.title}</h2>
              <p className="text-gray-600 text-sm mb-3">{announcement.content}</p>

              <div className="text-xs text-gray-400 flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                <span>
                  Објавено од: <span className="font-medium">{announcement.created_by}</span>
                </span>
                {announcement.expire_at && (
                  <span>
                    Истекува на:{' '}
                    {new Date(announcement.expire_at).toLocaleDateString('en-US', {
                      year: 'numeric',
                      month: 'short',
                      day: 'numeric',
                    })}
                  </span>
                )}
              </div>
            </div>
          ))
        )}

        {meta && meta.last_page > 1 && (
          <div className="mt-6 flex justify-center gap-2">
            <button
              onClick={() => setPage((p) => Math.max(1, p - 1))}
              disabled={page === 1}
              className="px-3 py-1 rounded border text-sm disabled:opacity-40 hover:bg-gray-200"
            >
              &laquo;
            </button>
            {Array.from({ length: meta.last_page }, (_, i) => i + 1).map((p) => (
              <button
                key={p}
                onClick={() => setPage(p)}
                className={`px-3 py-1 rounded border text-sm ${
                  p === page ? 'bg-emerald-500 text-white border-emerald-500' : 'hover:bg-gray-200'
                }`}
              >
                {p}
              </button>
            ))}
            <button
              onClick={() => setPage((p) => Math.min(meta.last_page, p + 1))}
              disabled={page === meta.last_page}
              className="px-3 py-1 rounded border text-sm disabled:opacity-40 hover:bg-gray-200"
            >
              &raquo;
            </button>
          </div>
        )}
      </div>
    </div>
  )
}
