USE master;
GO

BACKUP DATABASE clicgo
TO DISK = 'C:\xampp\htdocs\ClicGo\documents\Backups\clicgo_backup_2025_10_15.bak'
WITH
    FORMAT,
    INIT,
    NAME = 'Backup completo de ClicGo',
    DESCRIPTION = 'Respaldo de seguridad previo a modificaciones',
    STATS = 10;                -- Muestra progreso
GO

-------Restaurar Backups----------

USE master;
GO

ALTER DATABASE clicgo SET SINGLE_USER WITH ROLLBACK IMMEDIATE;
GO

RESTORE DATABASE clicgo
FROM DISK = 'C:\Backups\clicgo_backup_2025_10_15.bak'
WITH REPLACE,
     RECOVERY,
     STATS = 10;
GO

ALTER DATABASE clicgo SET MULTI_USER;
GO