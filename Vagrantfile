Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/trusty64"

  config.vm.provision "ansible", type: "ansible_local" do |a|
    a.playbook = "build/playbook.yml"
  end

  # This will expose API at http://localhost:8080
  config.vm.network "forwarded_port", guest: 80, host: 8080
end
