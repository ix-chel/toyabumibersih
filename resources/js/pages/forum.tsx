import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { PlusCircle } from "lucide-react"
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar"

export default function ForumPage() {
  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <h1 className="text-2xl font-semibold">Forum</h1>
        <Button>
          <PlusCircle className="mr-2 h-4 w-4" />
          New Discussion
        </Button>
      </div>

      <Card>
        <CardHeader>
          <CardTitle>Recent Discussions</CardTitle>
        </CardHeader>
        <CardContent className="space-y-4">
          <div className="flex items-start space-x-4">
            <Avatar>
              <AvatarImage src="/avatars/01.png" />
              <AvatarFallback>JD</AvatarFallback>
            </Avatar>
            <div className="flex-1 space-y-1">
              <p className="text-sm font-medium leading-none">How to maintain water filter properly?</p>
              <p className="text-sm text-muted-foreground">
                Posted by John Doe • 2 hours ago
              </p>
            </div>
            <Button variant="ghost" size="sm">
              Reply
            </Button>
          </div>
        </CardContent>
      </Card>
    </div>
  )
} 