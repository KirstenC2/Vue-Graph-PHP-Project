namespace CRM.Models
{
    public class User
    {
        public class User
        {
            public int Id { get; set; }              // 主鍵
            public string Username { get; set; }     // 使用者名稱
            public string Email { get; set; }        // Email
            public string PasswordHash { get; set; } // 密碼（加密儲存）
            public DateTime CreatedAt { get; set; } = DateTime.UtcNow;
        }
    }
