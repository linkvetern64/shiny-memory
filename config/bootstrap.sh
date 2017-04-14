# Vagrant setup

sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
sudo apt-get update
sudo apt-get install -y mysql-server curl
sudo apt-get install -y apache2 php5 php-pear php5-mysql php5-curl php5-mcrypt

sudo a2enmod rewrite

cat /var/config_files/site.conf > /etc/apache2/sites-available/000-default.conf

sudo sed -i 's/127.0.0.1/0.0.0.0/g' /etc/mysql/my.cnf

#echo "DROP DATABASE IF EXISTS test" | mysql -uroot -proot
#echo "CREATE USER 'devdb'@'localhost' IDENTIFIED BY 'devdb'" | mysql -uroot -proot;
#echo "CREATE USER 'devroot'@'%' IDENTIFIED BY 'devroot'" | mysql -uroot -proot;
#echo "CREATE DATABASE devdb" | mysql -uroot -proot;
#echo "GRANT ALL ON devdb.* TO 'devdb'@'localhost'" | mysql -uroot -proot;
#echo "GRANT ALL ON *.* TO 'devroot'@'%'" WITH GRANT OPTION | mysql -uroot -proot;

echo "127.0.0.1 db.dev" >> /etc/hosts

sudo service apache2 restart
sudo service mysql restart

#pushd;
#cd /srv/proj1
#php migration.php seed
#popd;

pushd;
cd /srv/webapp
php database/populate.php
popd;

