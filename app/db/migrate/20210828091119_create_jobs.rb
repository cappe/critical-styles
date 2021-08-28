class CreateJobs < ActiveRecord::Migration[6.1]
  def change
    create_table :jobs, id: :uuid do |t|
      t.string :jid, comment: "Active Job ID"

      t.belongs_to :domain, type: :uuid, foreign_key: true
      t.belongs_to :user, type: :uuid, foreign_key: true
      t.belongs_to :webpage, type: :uuid, foreign_key: true

      t.timestamps
    end
  end
end
