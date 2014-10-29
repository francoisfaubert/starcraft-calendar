class CreateWcs < ActiveRecord::Migration
  def change
    create_table :wcs do |t|
      t.string :name
      t.string :start
      t.string :created_at
      t.string :modified_at

      t.timestamps
    end
  end
end
