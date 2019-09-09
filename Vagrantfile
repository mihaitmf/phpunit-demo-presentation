# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.require_version '>= 2.1'

VAGRANTFILE_API_VERSION = '2'

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    PROJECT_NAME = 'phpunit-demo'
    PROJECT_DIR = '/var/' + PROJECT_NAME
    SHELL_PROVISIONING_RELATIVE_DIR = 'provisioners'
    MACHINE_IP_ADDRESS = '192.168.89.103'
    VAGRANT_BOX_NAME = 'ubuntu/bionic64'

    # Install plugins if missing
    required_plugins = %w(vagrant-vbguest)
    plugins_to_install = required_plugins.select {|plugin| not Vagrant.has_plugin? plugin}
    if plugins_to_install.any?
        puts "Installing plugins: #{plugins_to_install.join(' ')}"
        if system "vagrant plugin install #{plugins_to_install.join(' ')}"
            exec "vagrant #{ARGV.join(' ')}"
        else
            abort 'Installation of one or more plugins has failed. Aborting.'
        end
    end

    # Set auto_update to false, if you do NOT want to check the correct virtual-box-guest-additions version when booting VM
    if Vagrant.has_plugin?('vagrant-vbguest')
        config.vbguest.auto_update = false
    end

    # Configure vagrant machine
    config.vm.define "#{PROJECT_NAME}-vagrant", primary: true do |vm_config|
        vm_config.vm.box = VAGRANT_BOX_NAME
        vm_config.vm.box_check_update = true
        vm_config.vm.provider 'virtualbox' do |vb|
            vb.name = "#{PROJECT_NAME}-VM"
            vb.cpus = 2
            vb.memory = 4096
        end

        vm_config.vm.hostname = PROJECT_NAME
        vm_config.vm.network 'private_network', ip: MACHINE_IP_ADDRESS

        vm_config.ssh.insert_key = false

        vm_config.vm.synced_folder '.', '/vagrant', disabled: true
        vm_config.vm.synced_folder '.', PROJECT_DIR, create: true

        # Run vagrant provisioner
        vm_config.vm.provision 'install-packages',
            type: 'shell',
            run: 'once',
            args: ["#{PROJECT_DIR}", "#{SHELL_PROVISIONING_RELATIVE_DIR}"],
            path: "#{SHELL_PROVISIONING_RELATIVE_DIR}/install-packages.sh"
    end
end
