# Booking web - Laravel Application - EC2 Docker Deployment

A booking web production-ready Laravel application deployed on AWS EC2 using Docker Compose.

## Architecture

- **Web Server**: Nginx (reverse proxy)
- **Application**: PHP-FPM 8.2 with Laravel
- **Database**: MySQL 8.0
- **Cache/Queue**: Redis
- **Container Orchestration**: Docker Compose

## Prerequisites

- AWS EC2 instance (Ubuntu 22.04 LTS recommended)
- Docker and Docker Compose installed
- Domain name (optional, for SSL)
- SSH access to EC2 instance

## Project Structure

```
.

│   
├── nginx.conf
├── Dockerfile
├── docker-compose.yml
├── .env
├── .env.example
└── README.md
```

## Installation

### 1. EC2 Setup

Connect to your EC2 instance:

```bash
ssh -i your-key.pem ubuntu@your-ec2-ip
```

Update system packages:

```bash
sudo apt update && sudo apt upgrade -y
```

Install Docker:

```bash
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
sudo usermod -aG docker $USER
```

Install Docker Compose:

```bash
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
```

Log out and back in for group changes to take effect.

### 2. Clone Repository

```bash
git clone https://github.com/your-username/your-laravel-project.git
cd your-laravel-project
```

### 3. Environment Configuration

Copy and configure environment file:

```bash
cp .env.example .env
```

Update the following variables in `.env`:

```env
APP_NAME="Your App Name"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://your-domain.com

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=your_secure_password

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 4. Build and Start Containers

```bash
docker compose up -d --build
```

### 5. Install Dependencies and Setup

```bash
# Install Composer dependencies
docker compose exec app composer install --optimize-autoloader --no-dev

# Generate application key
docker compose exec app php artisan key:generate

# Run migrations
docker compose exec app php artisan migrate --force

# Cache configuration
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache

# Create storage link
docker-compose exec app php artisan storage:link
```

### 6. Set Permissions

```bash
docker compose exec app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
docker compose exec app chmod -R 775 /var/www/storage /var/www/bootstrap/cache
```

## Docker Compose Services

### Application (app)
- PHP 8.2-FPM
- Laravel application code
- Composer dependencies
- Port: Internal only

### Web Server (nginx)
- Nginx latest
- Reverse proxy to PHP-FPM
- Port: 80 (HTTP), 443 (HTTPS)

### Database (mysql)
- MySQL 8.0
- Persistent data volume
- Port: 3306 (internal)

### Cache/Queue (redis)
- Redis latest
- Session and cache storage
- Port: 6379 (internal)

## Common Commands

### View Logs

```bash
# All services
docker compose logs -f

# Specific service
docker compose logs -f app
docker compose logs -f nginx
```

### Access Container Shell

```bash
docker compose exec app bash
docker compose exec mysql mysql -u root -p
```

### Run Artisan Commands

```bash
docker compose exec app php artisan [command]
```

### Database Operations

```bash
# Create backup
docker compose exec mysql mysqldump -u root -p laravel > backup.sql

# Restore backup
docker compose exec -T mysql mysql -u root -p laravel < backup.sql
```

### Queue Worker

```bash
# Start queue worker
docker compose exec app php artisan queue:work --daemon

# Or add to supervisor configuration
```

### Update Application

```bash
git pull origin main
docker compose exec app composer install --optimize-autoloader --no-dev
docker compose exec app php artisan migrate --force
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache
docker compose restart app
```

## Security Configurations

### EC2 Security Group

Configure inbound rules:
- HTTP (80): 0.0.0.0/0
- HTTPS (443): 0.0.0.0/0
- SSH (22): Your IP only
- MySQL (3306): Blocked externally

### SSL Certificate (Let's Encrypt)

```bash
# Install certbot
sudo apt install certbot python3-certbot-nginx -y

# Stop nginx container temporarily
docker compose stop nginx

# Obtain certificate
sudo certbot certonly --standalone -d your-domain.com

# Update nginx configuration with SSL
# Restart nginx
docker compose start nginx
```

## Monitoring and Maintenance

### Disk Space

```bash
# Check disk usage
df -h

# Clean Docker system
docker system prune -a
```

### Container Health

```bash
docker compose ps
docker stats
```

### Database Size

```bash
docker compose exec mysql mysql -u root -p -e "SELECT table_schema AS 'Database', ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'Size (MB)' FROM information_schema.tables GROUP BY table_schema;"
```

### Application Not Accessible

```bash
# Check container status
docker compose ps

# Check logs
docker compose logs nginx
docker compose logs app

# Verify port mappings
docker compose port nginx 80
```

### Database Connection Issues

```bash
# Test MySQL connection
docker compose exec app php artisan tinker
# Then run: DB::connection()->getPdo();

# Check MySQL logs
docker compose logs mysql
```

### Permission Errors

```bash
docker compose exec app chown -R www-data:www-data /var/www
docker compose exec app chmod -R 775 /var/www/storage /var/www/bootstrap/cache
```

## Performance Optimization

### Enable OPcache

Add to `docker/php/Dockerfile`:

```dockerfile
RUN docker-php-ext-install opcache
```

### Redis Configuration

Optimize Redis for production in `docker-compose.yml`:

```yaml
redis:
  command: redis-server --appendonly yes --maxmemory 256mb --maxmemory-policy allkeys-lru
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For issues and questions:
- Create an issue on GitHub
- Email: support@yourdomain.com

## Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Docker Documentation](https://docs.docker.com)
- [AWS EC2 Documentation](https://docs.aws.amazon.com/ec2)