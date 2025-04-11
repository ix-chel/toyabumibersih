"use client"

import { useState } from "react"
import {
  BarChart as LucideBarChart,
  CalendarDays,
  CheckCircle,
  Clock,
  Filter,
  Package,
  Settings,
  ShoppingCart,
  Users,
  AlertTriangle,
  MoreHorizontal,
  ArrowUpRight,
  ArrowDownRight,
  Bell,
  LogOut,
  Search,
  PlusCircle,
  LayoutDashboard,
  Wrench,
  Building2,
  CreditCard,
  Truck,
  MessageSquare,
  BarChart3,
  UserCog,
  ChevronRight,
  Calendar,
  MapPin,
  Phone,
  Mail,
  Edit,
  Trash2,
  CheckSquare,
  XCircle,
  RefreshCw,
  Download,
} from "lucide-react"
import { BarChart, Bar, Tooltip, XAxis, YAxis } from "recharts"

import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs"
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar"
import { Badge } from "@/components/ui/badge"
import { Progress } from "@/components/ui/progress"
import { Input } from "@/components/ui/input"
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu"
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/components/ui/dialog"
import { Label } from "@/components/ui/label"
import { Separator } from "@/components/ui/separator"
import { ThemeToggle } from "@/components/theme-toggle"

export default function DashboardPage() {
  const [activeView, setActiveView] = useState("dashboard")
  const [sidebarOpen, setSidebarOpen] = useState(true)

  const renderContent = () => {
    switch (activeView) {
      case "dashboard":
        return <DashboardView />
      case "clients":
        return <ClientsView />
      case "filters":
        return <FiltersView />
      case "maintenance":
        return <MaintenanceView />
      case "inventory":
        return <InventoryView />
      case "invoices":
        return <InvoicesView />
      case "forum":
        return <ForumView />
      case "reports":
        return <ReportsView />
      case "users":
        return <UsersView />
      default:
        return <DashboardView />
    }
  }

  return (
    <div className="flex min-h-screen w-full">
      {/* Sidebar */}
      <div className={`bg-card border-r transition-all duration-300 ${sidebarOpen ? "w-64" : "w-20"}`}>
        <div className="flex h-16 items-center border-b px-4">
          <div className="flex items-center gap-2">
            <Filter className="h-6 w-6 text-primary" />
            {sidebarOpen && <span className="font-semibold">Toya Bumi Bersih</span>}
          </div>
          <Button variant="ghost" size="icon" className="ml-auto" onClick={() => setSidebarOpen(!sidebarOpen)}>
            <ChevronRight className={`h-4 w-4 transition-all ${!sidebarOpen ? "rotate-180" : ""}`} />
          </Button>
        </div>
        <div className="py-4">
          <nav className="grid gap-1 px-2">
            {[
              { icon: LayoutDashboard, label: "Dashboard", id: "dashboard" },
              { icon: Building2, label: "Clients", id: "clients" },
              { icon: Filter, label: "Filters", id: "filters" },
              { icon: Wrench, label: "Maintenance", id: "maintenance" },
              { icon: Package, label: "Inventory", id: "inventory" },
              { icon: CreditCard, label: "Invoices", id: "invoices" },
              
              { icon: MessageSquare, label: "Forum", id: "forum" },
              { icon: BarChart3, label: "Reports", id: "reports" },
              { icon: UserCog, label: "Users", id: "users" },
            ].map((item) => (
              <Button
                key={item.id}
                variant={activeView === item.id ? "secondary" : "ghost"}
                className={`flex justify-${sidebarOpen ? "start" : "center"} gap-2`}
                onClick={() => setActiveView(item.id)}
              >
                <item.icon className="h-4 w-4" />
                {sidebarOpen && <span>{item.label}</span>}
              </Button>
            ))}
          </nav>
        </div>
        <div className="absolute bottom-4 px-2 w-full">
          {sidebarOpen ? (
            <div className="border rounded-lg p-2">
              <div className="flex items-center gap-2">
                <Avatar className="h-8 w-8">
                  <AvatarImage src="/placeholder.svg" alt="Avatar" />
                  <AvatarFallback>AD</AvatarFallback>
                </Avatar>
                <div className="grid gap-0.5 text-sm">
                  <div className="font-medium">Alex Doe</div>
                  <div className="text-xs text-muted-foreground">Super Admin</div>
                </div>
                <DropdownMenu>
                  <DropdownMenuTrigger asChild>
                    <Button variant="ghost" size="icon" className="ml-auto h-8 w-8">
                      <MoreHorizontal className="h-4 w-4" />
                    </Button>
                  </DropdownMenuTrigger>
                  <DropdownMenuContent align="end">
                    <DropdownMenuItem>Profile</DropdownMenuItem>
                    <DropdownMenuItem>Settings</DropdownMenuItem>
                    <DropdownMenuSeparator />
                    <DropdownMenuItem>Logout</DropdownMenuItem>
                  </DropdownMenuContent>
                </DropdownMenu>
              </div>
            </div>
          ) : (
            <Button variant="ghost" size="icon" className="w-full">
              <Avatar className="h-8 w-8">
                <AvatarImage src="/placeholder.svg" alt="Avatar" />
                <AvatarFallback>AD</AvatarFallback>
              </Avatar>
            </Button>
          )}
        </div>
      </div>

      {/* Main Content */}
      <div className="flex flex-col flex-1">
        <header className="sticky top-0 z-30 flex h-16 items-center gap-4 border-b bg-background px-6">
          <div className="flex flex-1 items-center gap-2">
            <div className="relative w-full max-w-md">
              <Search className="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
              <Input
                type="search"
                placeholder="Search..."
                className="w-full bg-background pl-8 md:w-[300px] lg:w-[400px]"
              />
            </div>
          </div>
          <div className="flex items-center gap-2">
            <Button variant="ghost" size="icon">
              <Bell className="h-5 w-5" />
            </Button>
            <Button variant="ghost" size="icon">
              <Settings className="h-5 w-5" />
            </Button>
            <ThemeToggle />
            <Separator orientation="vertical" className="h-8" />
            <DropdownMenu>
              <DropdownMenuTrigger asChild>
                <Button variant="ghost" size="icon" className="rounded-full">
                  <Avatar className="h-8 w-8">
                    <AvatarImage src="/placeholder.svg" alt="Avatar" />
                    <AvatarFallback>AD</AvatarFallback>
                  </Avatar>
                </Button>
              </DropdownMenuTrigger>
              <DropdownMenuContent align="end">
                <DropdownMenuLabel>My Account</DropdownMenuLabel>
                <DropdownMenuSeparator />
                <DropdownMenuItem>
                  <User className="mr-2 h-4 w-4" />
                  <span>Profile</span>
                </DropdownMenuItem>
                <DropdownMenuItem>
                  <Settings className="mr-2 h-4 w-4" />
                  <span>Settings</span>
                </DropdownMenuItem>
                <DropdownMenuSeparator />
                <DropdownMenuItem>
                  <LogOut className="mr-2 h-4 w-4" />
                  <span>Logout</span>
                </DropdownMenuItem>
              </DropdownMenuContent>
            </DropdownMenu>
          </div>
        </header>
        <main className="flex-1 overflow-auto p-6">{renderContent()}</main>
      </div>
    </div>
  )
}

// Dashboard View Component
function DashboardView() {
  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <h1 className="text-2xl font-semibold">Dashboard</h1>
        <div className="flex items-center gap-2">
          <Select defaultValue="today">
            <SelectTrigger className="w-[180px]">
              <SelectValue placeholder="Select period" />
            </SelectTrigger>
            <SelectContent>
              <SelectItem value="today">Today</SelectItem>
              <SelectItem value="yesterday">Yesterday</SelectItem>
              <SelectItem value="week">This Week</SelectItem>
              <SelectItem value="month">This Month</SelectItem>
              <SelectItem value="year">This Year</SelectItem>
            </SelectContent>
          </Select>
          <Button>
            <RefreshCw className="mr-2 h-4 w-4" />
            Refresh
          </Button>
        </div>
      </div>

      <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Total Clients</CardTitle>
            <Users className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">42</div>
            <p className="text-xs text-muted-foreground">
              <span className="text-emerald-500 flex items-center gap-1">
                <ArrowUpRight className="h-3 w-3" />
                +5%
              </span>{" "}
              from last month
            </p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Active Filters</CardTitle>
            <Filter className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">187</div>
            <p className="text-xs text-muted-foreground">
              <span className="text-emerald-500 flex items-center gap-1">
                <ArrowUpRight className="h-3 w-3" />
                +12%
              </span>{" "}
              from last month
            </p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Pending Maintenance</CardTitle>
            <Clock className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">24</div>
            <p className="text-xs text-muted-foreground">
              <span className="text-rose-500 flex items-center gap-1">
                <ArrowDownRight className="h-3 w-3" />
                +8%
              </span>{" "}
              from last week
            </p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Low Stock Items</CardTitle>
            <ShoppingCart className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">7</div>
            <p className="text-xs text-muted-foreground">
              <span className="text-rose-500 flex items-center gap-1">
                <ArrowUpRight className="h-3 w-3" />
                +3
              </span>{" "}
              from yesterday
            </p>
          </CardContent>
        </Card>
      </div>

      <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-7">
        <Card className="lg:col-span-4">
          <CardHeader>
            <CardTitle>Maintenance Completion Rate</CardTitle>
          </CardHeader>
          <CardContent className="pl-2">
            <div className="h-[300px] w-full bg-muted rounded-md flex items-center justify-center">
              <BarChart className="h-16 w-16 text-muted-foreground" />
              <span className="ml-2 text-muted-foreground">Chart Placeholder</span>
            </div>
          </CardContent>
        </Card>
        <Card className="lg:col-span-3">
          <CardHeader>
            <CardTitle>Upcoming Maintenance</CardTitle>
            <CardDescription>Next 7 days scheduled maintenance</CardDescription>
          </CardHeader>
          <CardContent>
            <div className="space-y-4">
              {[
                {
                  client: "Acme Corp",
                  site: "Headquarters",
                  date: "Today, 2:00 PM",
                  status: "scheduled",
                  technician: "John Doe",
                },
                {
                  client: "TechGiant Inc",
                  site: "Building A",
                  date: "Tomorrow, 10:00 AM",
                  status: "scheduled",
                  technician: "Jane Smith",
                },
                {
                  client: "Global Foods",
                  site: "Processing Plant",
                  date: "Wed, 9:30 AM",
                  status: "scheduled",
                  technician: "Mike Johnson",
                },
                {
                  client: "City Hospital",
                  site: "Main Building",
                  date: "Thu, 1:15 PM",
                  status: "scheduled",
                  technician: "Sarah Williams",
                },
                {
                  client: "Metro University",
                  site: "Science Building",
                  date: "Fri, 11:00 AM",
                  status: "scheduled",
                  technician: "John Doe",
                },
              ].map((item, index) => (
                <div key={index} className="flex items-center">
                  <div className="flex items-center justify-center w-10">
                    <CalendarDays className="h-5 w-5 text-muted-foreground" />
                  </div>
                  <div className="ml-4 space-y-1 flex-1">
                    <p className="text-sm font-medium leading-none">{item.client}</p>
                    <p className="text-sm text-muted-foreground">{item.site}</p>
                    <div className="flex items-center pt-1">
                      <Badge variant="outline" className="text-xs">
                        {item.date}
                      </Badge>
                    </div>
                  </div>
                  <div className="ml-auto font-medium text-xs text-muted-foreground">{item.technician}</div>
                </div>
              ))}
            </div>
          </CardContent>
        </Card>
      </div>

      <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        <Card>
          <CardHeader className="pb-2">
            <CardTitle>Filter Status</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="space-y-4">
              <div className="flex items-center justify-between">
                <div className="flex items-center gap-2">
                  <div className="h-2 w-2 rounded-full bg-green-500" />
                  <span className="text-sm">Active</span>
                </div>
                <span className="text-sm font-medium">156</span>
              </div>
              <div className="flex items-center justify-between">
                <div className="flex items-center gap-2">
                  <div className="h-2 w-2 rounded-full bg-yellow-500" />
                  <span className="text-sm">Maintenance Due</span>
                </div>
                <span className="text-sm font-medium">24</span>
              </div>
              <div className="flex items-center justify-between">
                <div className="flex items-center gap-2">
                  <div className="h-2 w-2 rounded-full bg-red-500" />
                  <span className="text-sm">Critical</span>
                </div>
                <span className="text-sm font-medium">7</span>
              </div>
              <div className="pt-2">
                <Progress value={83} className="h-2" />
                <div className="flex justify-between text-xs text-muted-foreground mt-1">
                  <span>83% Healthy</span>
                  <span>187 Total</span>
                </div>
              </div>
            </div>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="pb-2">
            <CardTitle>Recent Activities</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="space-y-4">
              {[
                {
                  icon: CheckCircle,
                  description: "Filter maintenance completed",
                  time: "2 hours ago",
                  color: "text-green-500",
                },
                {
                  icon: Package,
                  description: "New inventory items added",
                  time: "5 hours ago",
                  color: "text-blue-500",
                },
                {
                  icon: AlertTriangle,
                  description: "Low stock alert triggered",
                  time: "Yesterday",
                  color: "text-amber-500",
                },
                {
                  icon: Users,
                  description: "New client onboarded",
                  time: "2 days ago",
                  color: "text-indigo-500",
                },
              ].map((item, index) => (
                <div key={index} className="flex items-center">
                  <div className={`${item.color}`}>
                    <item.icon className="h-5 w-5" />
                  </div>
                  <div className="ml-4 space-y-1">
                    <p className="text-sm">{item.description}</p>
                    <p className="text-xs text-muted-foreground">{item.time}</p>
                  </div>
                  <div className="ml-auto">
                    <Button variant="ghost" size="icon" className="h-8 w-8">
                      <MoreHorizontal className="h-4 w-4" />
                    </Button>
                  </div>
                </div>
              ))}
            </div>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="pb-2">
            <CardTitle>Inventory Status</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="space-y-4">
              {[
                {
                  name: "Carbon Filters",
                  stock: 85,
                  status: "In Stock",
                },
                {
                  name: "UV Lamps",
                  stock: 32,
                  status: "In Stock",
                },
                {
                  name: "Filter Housing",
                  stock: 12,
                  status: "Low Stock",
                },
                {
                  name: "O-Rings",
                  stock: 5,
                  status: "Critical",
                },
              ].map((item, index) => (
                <div key={index} className="flex items-center justify-between">
                  <div>
                    <p className="text-sm font-medium">{item.name}</p>
                    <p className="text-xs text-muted-foreground">{item.stock} units</p>
                  </div>
                  <Badge
                    variant={
                      item.status === "In Stock" ? "outline" : item.status === "Low Stock" ? "secondary" : "destructive"
                    }
                  >
                    {item.status}
                  </Badge>
                </div>
              ))}
              <Button variant="outline" className="w-full mt-2">
                View All Inventory
              </Button>
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  )
}

// Clients View Component
function ClientsView() {
  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <h1 className="text-2xl font-semibold">Client Management</h1>
        <Button>
          <PlusCircle className="mr-2 h-4 w-4" />
          Add New Client
        </Button>
      </div>

      <div className="flex items-center gap-2">
        <div className="relative flex-1">
          <Search className="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
          <Input type="search" placeholder="Search clients..." className="pl-8 w-full md:max-w-sm" />
        </div>
        <Select defaultValue="all">
          <SelectTrigger className="w-[180px]">
            <SelectValue placeholder="Filter by status" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="all">All Clients</SelectItem>
            <SelectItem value="active">Active</SelectItem>
            <SelectItem value="inactive">Inactive</SelectItem>
          </SelectContent>
        </Select>
      </div>

      <Card>
        <CardContent className="p-0">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Company Name</TableHead>
                <TableHead>Contact Person</TableHead>
                <TableHead>Email</TableHead>
                <TableHead>Phone</TableHead>
                <TableHead>Sites</TableHead>
                <TableHead>Status</TableHead>
                <TableHead className="text-right">Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {[
                {
                  company: "Acme Corporation",
                  contact: "John Smith",
                  email: "john@acmecorp.com",
                  phone: "(555) 123-4567",
                  sites: 3,
                  status: "Active",
                },
                {
                  company: "TechGiant Inc",
                  contact: "Sarah Johnson",
                  email: "sarah@techgiant.com",
                  phone: "(555) 987-6543",
                  sites: 5,
                  status: "Active",
                },
                {
                  company: "Global Foods",
                  contact: "Michael Brown",
                  email: "michael@globalfoods.com",
                  phone: "(555) 456-7890",
                  sites: 2,
                  status: "Active",
                },
                {
                  company: "City Hospital",
                  contact: "Emily Davis",
                  email: "emily@cityhospital.org",
                  phone: "(555) 789-0123",
                  sites: 1,
                  status: "Active",
                },
                {
                  company: "Metro University",
                  contact: "Robert Wilson",
                  email: "robert@metrouniv.edu",
                  phone: "(555) 234-5678",
                  sites: 4,
                  status: "Inactive",
                },
              ].map((client, index) => (
                <TableRow key={index}>
                  <TableCell className="font-medium">{client.company}</TableCell>
                  <TableCell>{client.contact}</TableCell>
                  <TableCell>{client.email}</TableCell>
                  <TableCell>{client.phone}</TableCell>
                  <TableCell>{client.sites}</TableCell>
                  <TableCell>
                    <Badge variant={client.status === "Active" ? "outline" : "secondary"}>{client.status}</Badge>
                  </TableCell>
                  <TableCell className="text-right">
                    <div className="flex justify-end gap-2">
                      <Button variant="ghost" size="icon">
                        <Edit className="h-4 w-4" />
                      </Button>
                      <Button variant="ghost" size="icon">
                        <Trash2 className="h-4 w-4" />
                      </Button>
                      <Button variant="ghost" size="icon">
                        <MoreHorizontal className="h-4 w-4" />
                      </Button>
                    </div>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </CardContent>
        <CardFooter className="flex items-center justify-between border-t p-4">
          <div className="text-sm text-muted-foreground">Showing 5 of 42 clients</div>
          <div className="flex items-center gap-2">
            <Button variant="outline" size="sm" disabled>
              Previous
            </Button>
            <Button variant="outline" size="sm">
              Next
            </Button>
          </div>
        </CardFooter>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle>Client Details</CardTitle>
          <CardDescription>View and manage detailed information for Acme Corporation</CardDescription>
        </CardHeader>
        <CardContent>
          <div className="grid gap-6 md:grid-cols-2">
            <div>
              <h3 className="text-lg font-medium">Company Information</h3>
              <div className="mt-3 space-y-3">
                <div className="flex items-center gap-2">
                  <Building2 className="h-4 w-4 text-muted-foreground" />
                  <span className="text-sm">Acme Corporation</span>
                </div>
                <div className="flex items-center gap-2">
                  <MapPin className="h-4 w-4 text-muted-foreground" />
                  <span className="text-sm">123 Business Ave, Suite 100, Business City, BC 12345</span>
                </div>
                <div className="flex items-center gap-2">
                  <Calendar className="h-4 w-4 text-muted-foreground" />
                  <span className="text-sm">Client since: Jan 15, 2022</span>
                </div>
              </div>
            </div>
            <div>
              <h3 className="text-lg font-medium">Contact Information</h3>
              <div className="mt-3 space-y-3">
                <div className="flex items-center gap-2">
                  <Users className="h-4 w-4 text-muted-foreground" />
                  <span className="text-sm">John Smith (Primary Contact)</span>
                </div>
                <div className="flex items-center gap-2">
                  <Phone className="h-4 w-4 text-muted-foreground" />
                  <span className="text-sm">(555) 123-4567</span>
                </div>
                <div className="flex items-center gap-2">
                  <Mail className="h-4 w-4 text-muted-foreground" />
                  <span className="text-sm">john@acmecorp.com</span>
                </div>
              </div>
            </div>
          </div>

          <Separator className="my-6" />

          <div>
            <h3 className="text-lg font-medium mb-4">Sites</h3>
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>Site Name</TableHead>
                  <TableHead>Address</TableHead>
                  <TableHead>Contact</TableHead>
                  <TableHead>Filters</TableHead>
                  <TableHead className="text-right">Actions</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {[
                  {
                    name: "Headquarters",
                    address: "123 Business Ave, Business City",
                    contact: "John Smith",
                    filters: 5,
                  },
                  {
                    name: "Manufacturing Plant",
                    address: "456 Industry Blvd, Business City",
                    contact: "Mike Johnson",
                    filters: 12,
                  },
                  {
                    name: "Distribution Center",
                    address: "789 Logistics Way, Shipping Town",
                    contact: "Lisa Brown",
                    filters: 8,
                  },
                ].map((site, index) => (
                  <TableRow key={index}>
                    <TableCell className="font-medium">{site.name}</TableCell>
                    <TableCell>{site.address}</TableCell>
                    <TableCell>{site.contact}</TableCell>
                    <TableCell>{site.filters}</TableCell>
                    <TableCell className="text-right">
                      <div className="flex justify-end gap-2">
                        <Button variant="ghost" size="icon">
                          <Edit className="h-4 w-4" />
                        </Button>
                        <Button variant="ghost" size="icon">
                          <Trash2 className="h-4 w-4" />
                        </Button>
                      </div>
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
            <div className="mt-4">
              <Button variant="outline" size="sm">
                <PlusCircle className="mr-2 h-4 w-4" />
                Add Site
              </Button>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
  )
}

// Filters View Component
function FiltersView() {
  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <h1 className="text-2xl font-semibold">Filter Management</h1>
        <Button>
          <PlusCircle className="mr-2 h-4 w-4" />
          Add New Filter
        </Button>
      </div>

      <div className="flex items-center gap-2">
        <div className="relative flex-1">
          <Search className="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
          <Input
            type="search"
            placeholder="Search filters by serial number, model, or site..."
            className="pl-8 w-full md:max-w-sm"
          />
        </div>
        <Select defaultValue="all">
          <SelectTrigger className="w-[180px]">
            <SelectValue placeholder="Filter by status" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="all">All Filters</SelectItem>
            <SelectItem value="active">Active</SelectItem>
            <SelectItem value="maintenance">Maintenance</SelectItem>
            <SelectItem value="inactive">Inactive</SelectItem>
          </SelectContent>
        </Select>
      </div>

      <Card>
        <CardContent className="p-0">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Serial Number</TableHead>
                <TableHead>Model</TableHead>
                <TableHead>Site</TableHead>
                <TableHead>Client</TableHead>
                <TableHead>Installation Date</TableHead>
                <TableHead>Status</TableHead>
                <TableHead className="text-right">Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {[
                {
                  serial: "FLT-2023-001",
                  model: "AquaPure X100",
                  site: "Acme Corp - Headquarters",
                  client: "Acme Corporation",
                  installed: "Jan 15, 2023",
                  status: "Active",
                },
                {
                  serial: "FLT-2023-015",
                  model: "AquaPure X200",
                  site: "TechGiant - Building A",
                  client: "TechGiant Inc",
                  installed: "Feb 22, 2023",
                  status: "Maintenance",
                },
                {
                  serial: "FLT-2023-042",
                  model: "HydroClean Pro",
                  site: "Global Foods - Processing Plant",
                  client: "Global Foods",
                  installed: "Mar 10, 2023",
                  status: "Active",
                },
                {
                  serial: "FLT-2023-078",
                  model: "AquaPure X100",
                  site: "City Hospital - Main Building",
                  client: "City Hospital",
                  installed: "Apr 05, 2023",
                  status: "Active",
                },
                {
                  serial: "FLT-2022-156",
                  model: "HydroClean Basic",
                  site: "Metro University - Science Building",
                  client: "Metro University",
                  installed: "Nov 20, 2022",
                  status: "Inactive",
                },
              ].map((filter, index) => (
                <TableRow key={index}>
                  <TableCell className="font-medium">{filter.serial}</TableCell>
                  <TableCell>{filter.model}</TableCell>
                  <TableCell>{filter.site}</TableCell>
                  <TableCell>{filter.client}</TableCell>
                  <TableCell>{filter.installed}</TableCell>
                  <TableCell>
                    <Badge
                      variant={
                        filter.status === "Active"
                          ? "outline"
                          : filter.status === "Maintenance"
                            ? "secondary"
                            : "destructive"
                      }
                    >
                      {filter.status}
                    </Badge>
                  </TableCell>
                  <TableCell className="text-right">
                    <div className="flex justify-end gap-2">
                      <Button variant="ghost" size="icon">
                        <Edit className="h-4 w-4" />
                      </Button>
                      <Button variant="ghost" size="icon">
                        <Wrench className="h-4 w-4" />
                      </Button>
                      <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                          <Button variant="ghost" size="icon">
                            <MoreHorizontal className="h-4 w-4" />
                          </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end">
                          <DropdownMenuItem>View Details</DropdownMenuItem>
                          <DropdownMenuItem>Schedule Maintenance</DropdownMenuItem>
                          <DropdownMenuItem>View History</DropdownMenuItem>
                          <DropdownMenuSeparator />
                          <DropdownMenuItem className="text-destructive">Deactivate</DropdownMenuItem>
                        </DropdownMenuContent>
                      </DropdownMenu>
                    </div>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </CardContent>
        <CardFooter className="flex items-center justify-between border-t p-4">
          <div className="text-sm text-muted-foreground">Showing 5 of 187 filters</div>
          <div className="flex items-center gap-2">
            <Button variant="outline" size="sm" disabled>
              Previous
            </Button>
            <Button variant="outline" size="sm">
              Next
            </Button>
          </div>
        </CardFooter>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle>Filter Details</CardTitle>
          <CardDescription>View and manage detailed information for filter FLT-2023-001</CardDescription>
        </CardHeader>
        <CardContent>
          <div className="grid gap-6 md:grid-cols-2">
            <div>
              <h3 className="text-lg font-medium">Filter Information</h3>
              <div className="mt-3 space-y-3">
                <div className="grid grid-cols-2 gap-1">
                  <div className="text-sm font-medium">Serial Number:</div>
                  <div className="text-sm">FLT-2023-001</div>

                  <div className="text-sm font-medium">Model:</div>
                  <div className="text-sm">AquaPure X100</div>

                  <div className="text-sm font-medium">Installation Date:</div>
                  <div className="text-sm">Jan 15, 2023</div>

                  <div className="text-sm font-medium">Warranty Expiry:</div>
                  <div className="text-sm">Jan 15, 2025</div>

                  <div className="text-sm font-medium">Status:</div>
                  <div className="text-sm">
                    <Badge variant="outline">Active</Badge>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <h3 className="text-lg font-medium">Location Information</h3>
              <div className="mt-3 space-y-3">
                <div className="grid grid-cols-2 gap-1">
                  <div className="text-sm font-medium">Client:</div>
                  <div className="text-sm">Acme Corporation</div>

                  <div className="text-sm font-medium">Site:</div>
                  <div className="text-sm">Headquarters</div>

                  <div className="text-sm font-medium">Address:</div>
                  <div className="text-sm">123 Business Ave, Business City</div>

                  <div className="text-sm font-medium">Contact:</div>
                  <div className="text-sm">John Smith</div>

                  <div className="text-sm font-medium">Phone:</div>
                  <div className="text-sm">(555) 123-4567</div>
                </div>
              </div>
            </div>
          </div>

          <Separator className="my-6" />

          <div>
            <h3 className="text-lg font-medium mb-4">Maintenance History</h3>
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>Date</TableHead>
                  <TableHead>Type</TableHead>
                  <TableHead>Technician</TableHead>
                  <TableHead>Parts Used</TableHead>
                  <TableHead>Status</TableHead>
                  <TableHead className="text-right">Actions</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {[
                  {
                    date: "Mar 15, 2023",
                    type: "Routine",
                    technician: "John Doe",
                    parts: "Carbon Filter, O-Rings",
                    status: "Completed",
                  },
                  {
                    date: "Jan 15, 2023",
                    type: "Installation",
                    technician: "Mike Johnson",
                    parts: "None",
                    status: "Completed",
                  },
                ].map((maintenance, index) => (
                  <TableRow key={index}>
                    <TableCell>{maintenance.date}</TableCell>
                    <TableCell>{maintenance.type}</TableCell>
                    <TableCell>{maintenance.technician}</TableCell>
                    <TableCell>{maintenance.parts}</TableCell>
                    <TableCell>
                      <Badge variant="outline">{maintenance.status}</Badge>
                    </TableCell>
                    <TableCell className="text-right">
                      <Button variant="ghost" size="sm">
                        View Report
                      </Button>
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
            <div className="mt-4 flex gap-2">
              <Button>
                <CalendarDays className="mr-2 h-4 w-4" />
                Schedule Maintenance
              </Button>
              <Button variant="outline">View Full History</Button>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
  )
}

// Maintenance View Component
function MaintenanceView() {
  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <h1 className="text-2xl font-semibold">Maintenance Management</h1>
        <div className="flex gap-2">
          <Button variant="outline">
            <Calendar className="mr-2 h-4 w-4" />
            Calendar View
          </Button>
          <Button>
            <PlusCircle className="mr-2 h-4 w-4" />
            Schedule Maintenance
          </Button>
        </div>
      </div>

      <Tabs defaultValue="upcoming">
        <TabsList className="grid w-full grid-cols-4">
          <TabsTrigger value="upcoming">Upcoming</TabsTrigger>
          <TabsTrigger value="completed">Completed</TabsTrigger>
          <TabsTrigger value="overdue">Overdue</TabsTrigger>
          <TabsTrigger value="all">All</TabsTrigger>
        </TabsList>
        <TabsContent value="upcoming" className="mt-4">
          <Card>
            <CardContent className="p-0">
              <Table>
                <TableHeader>
                  <TableRow>
                    <TableHead>Date & Time</TableHead>
                    <TableHead>Client</TableHead>
                    <TableHead>Site</TableHead>
                    <TableHead>Filter</TableHead>
                    <TableHead>Type</TableHead>
                    <TableHead>Technician</TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead className="text-right">Actions</TableHead>
                  </TableRow>
                </TableHeader>
                <TableBody>
                  {[
                    {
                      date: "Today, 2:00 PM",
                      client: "Acme Corporation",
                      site: "Headquarters",
                      filter: "FLT-2023-001",
                      type: "Routine",
                      technician: "John Doe",
                      status: "Scheduled",
                    },
                    {
                      date: "Tomorrow, 10:00 AM",
                      client: "TechGiant Inc",
                      site: "Building A",
                      filter: "FLT-2023-015",
                      type: "Repair",
                      technician: "Jane Smith",
                      status: "Scheduled",
                    },
                    {
                      date: "Wed, 9:30 AM",
                      client: "Global Foods",
                      site: "Processing Plant",
                      filter: "FLT-2023-042",
                      type: "Inspection",
                      technician: "Mike Johnson",
                      status: "Scheduled",
                    },
                    {
                      date: "Thu, 1:15 PM",
                      client: "City Hospital",
                      site: "Main Building",
                      filter: "FLT-2023-078",
                      type: "Routine",
                      technician: "Sarah Williams",
                      status: "Scheduled",
                    },
                    {
                      date: "Fri, 11:00 AM",
                      client: "Metro University",
                      site: "Science Building",
                      filter: "FLT-2022-156",
                      type: "Replacement",
                      technician: "John Doe",
                      status: "Scheduled",
                    },
                  ].map((maintenance, index) => (
                    <TableRow key={index}>
                      <TableCell>{maintenance.date}</TableCell>
                      <TableCell>{maintenance.client}</TableCell>
                      <TableCell>{maintenance.site}</TableCell>
                      <TableCell>{maintenance.filter}</TableCell>
                      <TableCell>{maintenance.type}</TableCell>
                      <TableCell>{maintenance.technician}</TableCell>
                      <TableCell>
                        <Badge variant="outline">{maintenance.status}</Badge>
                      </TableCell>
                      <TableCell className="text-right">
                        <div className="flex justify-end gap-2">
                          <Button variant="ghost" size="icon">
                            <Edit className="h-4 w-4" />
                          </Button>
                          <Button variant="ghost" size="icon">
                            <CheckSquare className="h-4 w-4" />
                          </Button>
                          <Button variant="ghost" size="icon">
                            <XCircle className="h-4 w-4" />
                          </Button>
                        </div>
                      </TableCell>
                    </TableRow>
                  ))}
                </TableBody>
              </Table>
            </CardContent>
          </Card>
        </TabsContent>
        <TabsContent value="completed" className="mt-4">
          <Card>
            <CardContent className="p-6">
              <div className="text-center py-10 text-muted-foreground">
                Completed maintenance records will appear here
              </div>
            </CardContent>
          </Card>
        </TabsContent>
        <TabsContent value="overdue" className="mt-4">
          <Card>
            <CardContent className="p-6">
              <div className="text-center py-10 text-muted-foreground">
                Overdue maintenance records will appear here
              </div>
            </CardContent>
          </Card>
        </TabsContent>
        <TabsContent value="all" className="mt-4">
          <Card>
            <CardContent className="p-6">
              <div className="text-center py-10 text-muted-foreground">All maintenance records will appear here</div>
            </CardContent>
          </Card>
        </TabsContent>
      </Tabs>

      <Card>
        <CardHeader>
          <CardTitle>Maintenance Report</CardTitle>
          <CardDescription>Complete the maintenance report for filter FLT-2023-001</CardDescription>
        </CardHeader>
        <CardContent>
          <div className="grid gap-6">
            <div className="grid gap-3">
              <h3 className="text-lg font-medium">Maintenance Information</h3>
              <div className="grid gap-2">
                <div className="grid grid-cols-2 gap-4">
                  <div className="space-y-2">
                    <Label htmlFor="service-date">Service Date</Label>
                    <Input id="service-date" type="date" />
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="service-time">Service Time</Label>
                    <Input id="service-time" type="time" />
                  </div>
                </div>
                <div className="space-y-2">
                  <Label htmlFor="findings">Findings</Label>
                  <Input id="findings" placeholder="Enter your findings..." />
                </div>
                <div className="space-y-2">
                  <Label htmlFor="actions">Actions Taken</Label>
                  <Input id="actions" placeholder="Describe actions taken..." />
                </div>
                <div className="space-y-2">
                  <Label htmlFor="recommendations">Recommendations</Label>
                  <Input id="recommendations" placeholder="Enter recommendations..." />
                </div>
              </div>
            </div>

            <Separator />

            <div className="grid gap-3">
              <h3 className="text-lg font-medium">Parts Used</h3>
              <Table>
                <TableHeader>
                  <TableRow>
                    <TableHead>Part Name</TableHead>
                    <TableHead>Quantity</TableHead>
                    <TableHead className="text-right">Actions</TableHead>
                  </TableRow>
                </TableHeader>
                <TableBody>
                  <TableRow>
                    <TableCell>
                      <Select>
                        <SelectTrigger>
                          <SelectValue placeholder="Select part" />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="carbon">Carbon Filter</SelectItem>
                          <SelectItem value="uv">UV Lamp</SelectItem>
                          <SelectItem value="housing">Filter Housing</SelectItem>
                          <SelectItem value="orings">O-Rings</SelectItem>
                        </SelectContent>
                      </Select>
                    </TableCell>
                    <TableCell>
                      <Input type="number" min="1" defaultValue="1" />
                    </TableCell>
                    <TableCell className="text-right">
                      <Button variant="ghost" size="icon">
                        <Trash2 className="h-4 w-4" />
                      </Button>
                    </TableCell>
                  </TableRow>
                </TableBody>
              </Table>
              <Button variant="outline" className="w-full">
                <PlusCircle className="mr-2 h-4 w-4" />
                Add Part
              </Button>
            </div>
          </div>
        </CardContent>
        <CardFooter className="flex justify-between">
          <Button variant="outline">Save as Draft</Button>
          <Button>Submit Report</Button>
        </CardFooter>
      </Card>
    </div>
  )
}

// Inventory View Component
function InventoryView() {
  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <h1 className="text-2xl font-semibold">Inventory Management</h1>
        <div className="flex gap-2">
          <Button variant="outline">
            <RefreshCw className="mr-2 h-4 w-4" />
            Refresh Stock
          </Button>
          <Button>
            <PlusCircle className="mr-2 h-4 w-4" />
            Add Inventory Item
          </Button>
        </div>
      </div>

      <div className="grid gap-4 md:grid-cols-3">
        <Card>
          <CardHeader className="pb-2">
            <CardTitle className="text-sm font-medium">Total Items</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">24</div>
            <p className="text-xs text-muted-foreground">4 categories</p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="pb-2">
            <CardTitle className="text-sm font-medium">Low Stock Items</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">7</div>
            <p className="text-xs text-muted-foreground">
              <span className="text-rose-500">Requires attention</span>
            </p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="pb-2">
            <CardTitle className="text-sm font-medium">Total Value</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">$12,450</div>
            <p className="text-xs text-muted-foreground">Based on current stock</p>
          </CardContent>
        </Card>
      </div>

      <Card>
        <CardHeader className="flex flex-row items-center">
          <div className="flex-1">
            <CardTitle>Inventory Items</CardTitle>
            <CardDescription>Manage your inventory items and stock levels</CardDescription>
          </div>
          <div className="flex items-center gap-2">
            <div className="relative">
              <Search className="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
              <Input type="search" placeholder="Search items..." className="pl-8 w-[200px]" />
            </div>
            <Select defaultValue="all">
              <SelectTrigger className="w-[150px]">
                <SelectValue placeholder="Filter by category" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="all">All Categories</SelectItem>
                <SelectItem value="filters">Filters</SelectItem>
                <SelectItem value="parts">Parts</SelectItem>
                <SelectItem value="tools">Tools</SelectItem>
                <SelectItem value="chemicals">Chemicals</SelectItem>
              </SelectContent>
            </Select>
          </div>
        </CardHeader>
        <CardContent className="p-0">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Item Code</TableHead>
                <TableHead>Name</TableHead>
                <TableHead>Category</TableHead>
                <TableHead>Current Stock</TableHead>
                <TableHead>Reorder Level</TableHead>
                <TableHead>Unit Price</TableHead>
                <TableHead>Status</TableHead>
                <TableHead className="text-right">Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {[
                {
                  code: "CF-100",
                  name: "Carbon Filter",
                  category: "Filters",
                  stock: 85,
                  reorder: 20,
                  price: "$45.00",
                  status: "In Stock",
                },
                {
                  code: "UV-200",
                  name: "UV Lamp",
                  category: "Parts",
                  stock: 32,
                  reorder: 15,
                  price: "$65.00",
                  status: "In Stock",
                },
                {
                  code: "FH-300",
                  name: "Filter Housing",
                  category: "Parts",
                  stock: 12,
                  reorder: 10,
                  price: "$120.00",
                  status: "Low Stock",
                },
                {
                  code: "OR-400",
                  name: "O-Rings",
                  category: "Parts",
                  stock: 5,
                  reorder: 50,
                  price: "$2.50",
                  status: "Critical",
                },
                {
                  code: "WT-500",
                  name: "Water Testing Kit",
                  category: "Tools",
                  stock: 18,
                  reorder: 5,
                  price: "$85.00",
                  status: "In Stock",
                },
              ].map((item, index) => (
                <TableRow key={index}>
                  <TableCell className="font-medium">{item.code}</TableCell>
                  <TableCell>{item.name}</TableCell>
                  <TableCell>{item.category}</TableCell>
                  <TableCell>{item.stock}</TableCell>
                  <TableCell>{item.reorder}</TableCell>
                  <TableCell>{item.price}</TableCell>
                  <TableCell>
                    <Badge
                      variant={
                        item.status === "In Stock"
                          ? "outline"
                          : item.status === "Low Stock"
                            ? "secondary"
                            : "destructive"
                      }
                    >
                      {item.status}
                    </Badge>
                  </TableCell>
                  <TableCell className="text-right">
                    <div className="flex justify-end gap-2">
                      <Dialog>
                        <DialogTrigger asChild>
                          <Button variant="ghost" size="icon">
                            <PlusCircle className="h-4 w-4" />
                          </Button>
                        </DialogTrigger>
                        <DialogContent>
                          <DialogHeader>
                            <DialogTitle>Adjust Stock</DialogTitle>
                            <DialogDescription>Add or remove stock for {item.name}</DialogDescription>
                          </DialogHeader>
                          <div className="grid gap-4 py-4">
                            <div className="grid grid-cols-4 items-center gap-4">
                              <Label htmlFor="quantity" className="text-right">
                                Quantity
                              </Label>
                              <Input id="quantity" type="number" className="col-span-3" />
                            </div>
                            <div className="grid grid-cols-4 items-center gap-4">
                              <Label htmlFor="reason" className="text-right">
                                Reason
                              </Label>
                              <Input id="reason" className="col-span-3" placeholder="Reason for adjustment" />
                            </div>
                          </div>
                          <DialogFooter>
                            <Button type="submit">Save changes</Button>
                          </DialogFooter>
                        </DialogContent>
                      </Dialog>
                      <Button variant="ghost" size="icon">
                        <Edit className="h-4 w-4" />
                      </Button>
                      <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                          <Button variant="ghost" size="icon">
                            <MoreHorizontal className="h-4 w-4" />
                          </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end">
                          <DropdownMenuItem>View History</DropdownMenuItem>
                          <DropdownMenuItem>Generate Report</DropdownMenuItem>
                          <DropdownMenuSeparator />
                          <DropdownMenuItem className="text-destructive">Delete Item</DropdownMenuItem>
                        </DropdownMenuContent>
                      </DropdownMenu>
                    </div>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </CardContent>
        <CardFooter className="flex items-center justify-between border-t p-4">
          <div className="text-sm text-muted-foreground">Showing 5 of 24 items</div>
          <div className="flex items-center gap-2">
            <Button variant="outline" size="sm" disabled>
              Previous
            </Button>
            <Button variant="outline" size="sm">
              Next
            </Button>
          </div>
        </CardFooter>
      </Card>
    </div>
  )
}

// Invoices View Component
function InvoicesView() {
  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <h1 className="text-2xl font-semibold">Invoice Management</h1>
        <Button>
          <PlusCircle className="mr-2 h-4 w-4" />
          Create Invoice
        </Button>
      </div>

      <div className="flex items-center gap-2">
        <div className="relative flex-1">
          <Search className="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
          <Input type="search" placeholder="Search invoices..." className="pl-8 w-full md:max-w-sm" />
        </div>
        <Select defaultValue="all">
          <SelectTrigger className="w-[180px]">
            <SelectValue placeholder="Filter by status" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="all">All Invoices</SelectItem>
            <SelectItem value="paid">Paid</SelectItem>
            <SelectItem value="pending">Pending</SelectItem>
            <SelectItem value="overdue">Overdue</SelectItem>
          </SelectContent>
        </Select>
      </div>

      <Card>
        <CardContent className="p-0">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Invoice Number</TableHead>
                <TableHead>Client</TableHead>
                <TableHead>Amount</TableHead>
                <TableHead>Status</TableHead>
                <TableHead>Due Date</TableHead>
                <TableHead className="text-right">Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {[
                {
                  number: "INV-2024-001",
                  client: "Acme Corporation",
                  amount: "Rp 1.500.000",
                  status: "Paid",
                  dueDate: "2024-04-15",
                },
                {
                  number: "INV-2024-002",
                  client: "TechGiant Inc",
                  amount: "Rp 2.750.000",
                  status: "Pending",
                  dueDate: "2024-04-20",
                },
                {
                  number: "INV-2024-003",
                  client: "Global Foods",
                  amount: "Rp 3.200.000",
                  status: "Overdue",
                  dueDate: "2024-04-10",
                },
              ].map((invoice, index) => (
                <TableRow key={index}>
                  <TableCell className="font-medium">{invoice.number}</TableCell>
                  <TableCell>{invoice.client}</TableCell>
                  <TableCell>{invoice.amount}</TableCell>
                  <TableCell>
                    <Badge
                      variant={
                        invoice.status === "Paid"
                          ? "outline"
                          : invoice.status === "Pending"
                            ? "secondary"
                            : "destructive"
                      }
                    >
                      {invoice.status}
                    </Badge>
                  </TableCell>
                  <TableCell>{invoice.dueDate}</TableCell>
                  <TableCell className="text-right">
                    <div className="flex justify-end gap-2">
                      <Button variant="ghost" size="icon">
                        <Edit className="h-4 w-4" />
                      </Button>
                      <Button variant="ghost" size="icon">
                        <Download className="h-4 w-4" />
                      </Button>
                    </div>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </CardContent>
      </Card>
    </div>
  )
}

// Forum View Component
function ForumView() {
  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <h1 className="text-2xl font-semibold">Forum Discussion</h1>
        <Button>
          <PlusCircle className="mr-2 h-4 w-4" />
          Start Discussion
        </Button>
      </div>

      <div className="flex items-center gap-2">
        <div className="relative flex-1">
          <Search className="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
          <Input type="search" placeholder="Search discussions..." className="pl-8 w-full md:max-w-sm" />
        </div>
        <Select defaultValue="all">
          <SelectTrigger className="w-[180px]">
            <SelectValue placeholder="Filter by category" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="all">All Categories</SelectItem>
            <SelectItem value="maintenance">Maintenance</SelectItem>
            <SelectItem value="technical">Technical</SelectItem>
            <SelectItem value="general">General</SelectItem>
          </SelectContent>
        </Select>
      </div>

      <div className="grid gap-4">
        {[
          {
            title: "Best practices for filter maintenance",
            author: "John Doe",
            category: "Maintenance",
            replies: 12,
            lastReply: "2 hours ago",
          },
          {
            title: "Troubleshooting UV lamp issues",
            author: "Jane Smith",
            category: "Technical",
            replies: 5,
            lastReply: "5 hours ago",
          },
          {
            title: "New product announcement",
            author: "Mike Johnson",
            category: "General",
            replies: 8,
            lastReply: "Yesterday",
          },
        ].map((discussion, index) => (
          <Card key={index}>
            <CardHeader>
              <div className="flex items-center justify-between">
                <CardTitle className="text-lg">{discussion.title}</CardTitle>
                <Badge variant="outline">{discussion.category}</Badge>
              </div>
              <div className="flex items-center gap-2 text-sm text-muted-foreground">
                <Avatar className="h-6 w-6">
                  <AvatarImage src="/placeholder.svg" alt={discussion.author} />
                  <AvatarFallback>{discussion.author.charAt(0)}</AvatarFallback>
                </Avatar>
                <span>Posted by {discussion.author}</span>
                <span>•</span>
                <span>{discussion.replies} replies</span>
                <span>•</span>
                <span>Last reply {discussion.lastReply}</span>
              </div>
            </CardHeader>
            <CardContent>
              <Button variant="outline" size="sm">
                <MessageSquare className="mr-2 h-4 w-4" />
                Reply
              </Button>
            </CardContent>
          </Card>
        ))}
      </div>
    </div>
  )
}

// Reports View Component
function ReportsView() {
  const data = [
    { name: "Jan", value: 12 },
    { name: "Feb", value: 19 },
    { name: "Mar", value: 15 },
    { name: "Apr", value: 8 },
    { name: "May", value: 10 },
  ]

  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <h1 className="text-2xl font-semibold">Reports</h1>
        <Button>
          <Download className="mr-2 h-4 w-4" />
          Export Report
        </Button>
      </div>

      <div className="grid gap-4 md:grid-cols-2">
        <Card>
          <CardHeader>
            <CardTitle>Monthly Maintenance</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="h-[300px] w-full">
              <BarChart
                width={500}
                height={300}
                data={data}
                margin={{ top: 5, right: 30, left: 20, bottom: 5 }}
              >
                <XAxis dataKey="name" />
                <YAxis />
                <Tooltip />
                <Bar dataKey="value" fill="#8884d8" />
              </BarChart>
            </div>
          </CardContent>
        </Card>

        <Card>
          <CardHeader>
            <CardTitle>Service Statistics</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="space-y-4">
              <div className="flex items-center justify-between">
                <div className="space-y-1">
                  <p className="text-sm font-medium">Total Services</p>
                  <p className="text-2xl font-bold">64</p>
                </div>
                <div className="space-y-1">
                  <p className="text-sm font-medium">Completed</p>
                  <p className="text-2xl font-bold">52</p>
                </div>
                <div className="space-y-1">
                  <p className="text-sm font-medium">Pending</p>
                  <p className="text-2xl font-bold">12</p>
                </div>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  )
}

// Users View Component
function UsersView() {
  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <h1 className="text-2xl font-semibold">User Management</h1>
        <Button>
          <PlusCircle className="mr-2 h-4 w-4" />
          Add User
        </Button>
      </div>

      <div className="flex items-center gap-2">
        <div className="relative flex-1">
          <Search className="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
          <Input type="search" placeholder="Search users..." className="pl-8 w-full md:max-w-sm" />
        </div>
        <Select defaultValue="all">
          <SelectTrigger className="w-[180px]">
            <SelectValue placeholder="Filter by role" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="all">All Roles</SelectItem>
            <SelectItem value="admin">Admin</SelectItem>
            <SelectItem value="technician">Technician</SelectItem>
            <SelectItem value="client">Client</SelectItem>
          </SelectContent>
        </Select>
      </div>

      <Card>
        <CardContent className="p-0">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>User</TableHead>
                <TableHead>Email</TableHead>
                <TableHead>Role</TableHead>
                <TableHead>Status</TableHead>
                <TableHead className="text-right">Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {[
                {
                  name: "John Doe",
                  email: "john@example.com",
                  role: "Admin",
                  status: "Active",
                },
                {
                  name: "Jane Smith",
                  email: "jane@example.com",
                  role: "Technician",
                  status: "Active",
                },
                {
                  name: "Mike Johnson",
                  email: "mike@example.com",
                  role: "Client",
                  status: "Inactive",
                },
              ].map((user, index) => (
                <TableRow key={index}>
                  <TableCell>
                    <div className="flex items-center gap-2">
                      <Avatar>
                        <AvatarImage src="/placeholder.svg" alt={user.name} />
                        <AvatarFallback>{user.name.charAt(0)}</AvatarFallback>
                      </Avatar>
                      <span>{user.name}</span>
                    </div>
                  </TableCell>
                  <TableCell>{user.email}</TableCell>
                  <TableCell>{user.role}</TableCell>
                  <TableCell>
                    <Badge variant={user.status === "Active" ? "outline" : "secondary"}>
                      {user.status}
                    </Badge>
                  </TableCell>
                  <TableCell className="text-right">
                    <Button variant="ghost" size="icon">
                      <Edit className="h-4 w-4" />
                    </Button>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </CardContent>
      </Card>
    </div>
  )
}

function User(props: any) {
  return (
    <svg
      {...props}
      xmlns="http://www.w3.org/2000/svg"
      width="24"
      height="24"
      viewBox="0 0 24 24"
      fill="none"
      stroke="currentColor"
      strokeWidth="2"
      strokeLinecap="round"
      strokeLinejoin="round"
    >
      <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
      <circle cx="12" cy="7" r="4" />
    </svg>
  )
}

