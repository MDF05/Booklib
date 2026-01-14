# Environment Variables

Configure your application using the `.env` file. Copy `.env.example` to start.

## App Settings
| Variable | Description | Default |
| :--- | :--- | :--- |
| `APP_NAME` | Name of the application | `Laravel` |
| `APP_ENV` | Environment (`local`, `production`) | `local` |
| `APP_DEBUG` | Enable debug mode (false in prod) | `true` |
| `APP_URL` | Base URL of the app | `http://localhost` |

## Database
| Variable | Description |
| :--- | :--- |
| `DB_CONNECTION` | Database type (`mysql`, `pgsql`, `sqlite`) |
| `DB_HOST` | Database host IP |
| `DB_PORT` | Database port (3306 for MySQL) |
| `DB_DATABASE` | Database name |
| `DB_USERNAME` | Database user |
| `DB_PASSWORD` | Database password |

## Mail (Optional)
| Variable | Description |
| :--- | :--- |
| `MAIL_MAILER` | Mail driver (`smtp`, `log`) |
| `MAIL_HOST` | SMTP Host |
| `MAIL_PORT` | SMTP Port |
| `MAIL_USERNAME` | SMTP User |
| `MAIL_PASSWORD` | SMTP Password |

## Other
| Variable | Description |
| :--- | :--- |
| `FILESYSTEM_DISK` | Storage disk (`local`, `s3`) |
| `QUEUE_CONNECTION` | Queue driver (`sync`, `database`, `redis`) |
