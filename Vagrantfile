# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure(2) do |config|
  config.vm.box = "debian/jessie64"
  config.vm.network "private_network", ip: "192.168.50.200"
  config.vm.network "forwarded_port", guest: 3306, host: 3306

  config.vm.provider "virtualbox" do |vb|
     vb.memory = "1024"
   end

  config.vm.provision :shell, inline: "apt-get update && apt-get install -y vim"
  config.vm.provision :docker
  config.vm.synced_folder ".", "/vagrant", type: 'nfs'
  config.vm.provision :docker_compose, run: "always", yml: "/vagrant/Provision/docker-compose.yml"
end
