import { Bell, Search } from "lucide-react";

interface TopbarProps {
    title: string;
}

const Topbar = ({ title }: TopbarProps) => {
    return (
        <header className="sticky top-0 z-20 bg-white border-b border-gray-200 h-20 flex items-center px-8 justify-between shadow-sm">
            <h1 className="text-2xl font-bold text-navy-900">{title}</h1>
            <div className="flex items-center gap-4">
                <div className="relative">
                    <input
                        type="text"
                        placeholder="Cari..."
                        className="pl-10 pr-4 py-2 rounded-lg border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-navy-200 text-sm"
                    />
                    <Search size={18} className="absolute left-3 top-2.5 text-gray-400" />
                </div>
                <button className="relative p-2 rounded-full hover:bg-gray-100">
                    <Bell size={22} className="text-navy-700" />
                    {/* Notification dot */}
                    <span className="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                <div className="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center font-bold text-navy-900">
                    U
                </div>
            </div>
        </header>
    );
};

export default Topbar;
