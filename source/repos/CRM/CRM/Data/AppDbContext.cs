using Microsoft.EntityFrameworkCore;
using CRM.Models; // replace with your actual namespace

namespace CRM.Data
{
    public class AppDbContext : DbContext
    {
        public AppDbContext(DbContextOptions<AppDbContext> options) : base(options) { }

        // Add your models here
        public DbSet<User> Users { get; set; }
    }
}