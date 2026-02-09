import React from "react";
import { NavLink, useLocation } from "react-router-dom";
import { LayoutDashboard, Search, FileText, User, Bell, LogOut, Briefcase, ClipboardList } from "lucide-react";

const navItems = [
  { to: "/dashboard", label: "Dashboard", icon: <LayoutDashboard size={20} /> },
  { to: "/jobs", label: "Cari Pekerjaan", icon: <Search size={20} /> },
  { to: "/applications", label: "Lamaran Saya", icon: <ClipboardList size={20} /> },
  { to: "/interviews", label: "Wawancara", icon: <Briefcase size={20} /> },
  { to: "/profile", label: "CV & Profil", icon: <User size={20} /> },
  { to: "/notifications", label: "Notifikasi", icon: <Bell size={20} /> },
];

const Sidebar = () => {
  const location = useLocation();
  return (
    <aside className="h-screen w-64 bg-white border-r border-gray-200 flex flex-col fixed left-0 top-0 z-30 shadow-lg">
      <div className="h-20 flex items-center justify-center border-b border-gray-200 font-bold text-xl tracking-wide text-navy-900">
        LookForJob
      </div>
      <nav className="flex-1 py-6">
        <ul className="space-y-2">
          {navItems.map((item) => (
            <li key={item.to}>
              <NavLink
                to={item.to}
                className={({ isActive }) =>
                  `flex items-center px-6 py-3 rounded-lg font-medium transition-colors duration-200 hover:bg-navy-50 hover:text-navy-700 ${
                    isActive || location.pathname === item.to
                      ? "bg-navy-100 text-navy-800 font-semibold"
                      : "text-gray-700"
                  }`
                }
              >
                <span className="mr-3">{item.icon}</span>
                {item.label}
              </NavLink>
            </li>
          ))}
        </ul>
      </nav>
      <div className="p-6 border-t border-gray-200">
        <button className="flex items-center w-full px-4 py-2 rounded-lg text-red-600 hover:bg-red-50 font-medium">
          <LogOut size={20} className="mr-3" /> Logout
        </button>
      </div>
    </aside>
  );
};

export default Sidebar; 