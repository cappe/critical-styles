class AddUrlToDomains < ActiveRecord::Migration[6.1]
  def change
    add_column :domains, :url, :string, null: false
  end
end
