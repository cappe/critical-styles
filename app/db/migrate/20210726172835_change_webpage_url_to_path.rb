class ChangeWebpageUrlToPath < ActiveRecord::Migration[6.1]
  def change
    rename_column :webpages, :url, :path
  end
end
