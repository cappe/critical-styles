class CreateWebpages < ActiveRecord::Migration[6.1]
  def change
    create_table :webpages, id: :uuid do |t|
      t.string :url, null: false
      t.index :url, unique: true
      t.belongs_to :domain, type: :uuid, foreign_key: true
      t.timestamps
    end
  end
end
