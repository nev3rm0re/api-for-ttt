Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/trusty64"

  config.vm.provision "ansible" do |a|
    a.playbook = "build/playbook.yml"
  end

  config.vm.network "forwarded_port", guest: 80, host: 8080
end
