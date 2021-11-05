class ScopeWebpagesPathUniqueness < ActiveRecord::Migration[6.1]
  def self.up
    remove_index :webpages, :path
    add_index :webpages, [:path, :domain_id], unique: true
  end

  def self.down
    remove_index :webpages, [:path, :domain_id]
    add_index :webpages, :path
  end
end
