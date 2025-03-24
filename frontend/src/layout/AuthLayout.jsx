import React from 'react'
import { Outlet } from 'react-router-dom'

const AuthLayout= () => {
  return (
    <div className="flex h-screen bg-gray-50">
      <div className="flex-grow px-4 sm:px-6">
        <Outlet />
      </div>
    </div>
    
  )
}

export default AuthLayout
