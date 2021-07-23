class CreateDomains < ActiveRecord::Migration[6.1]
  def change
    create_table :domains, id: :uuid do |t|
      t.belongs_to :user, type: :uuid, foreign_key: true
      t.timestamps
    end
  end
end
