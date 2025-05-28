
For EF core tools installation:

- please run the command below to allow the netcore can access to the SQL Server

```

dotnet add package Microsoft.EntityFrameworkCore.SqlServer
dotnet add package Microsoft.EntityFrameworkCore.Tools

```

This project used SQL Server in Docker:

```
docker pull mcr.microsoft.com/mssql/server:2022-latest
docker run -e "ACCEPT_EULA=Y" -e "SA_PASSWORD=YourStrong!Passw0rd" -p 1433:1433 --name sqlserver -d mcr.microsoft.com/mssql/server:2022-latest
```

```
dotnet tool install --global dotnet-ef     # if not already installed
dotnet ef migrations add InitialCreate
dotnet ef database update
```