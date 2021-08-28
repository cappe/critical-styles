class CreateJobs < ActiveRecord::Migration[6.1]
  def change
    create_table :jobs, id: :uuid do |t|
      t.string :jid, comment: "Active Job ID"

      t.belongs_to :domain
      t.belongs_to :user
      t.belongs_to :webpage

      t.timestamps
    end
  end
end
