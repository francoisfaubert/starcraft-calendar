class AddEndToWcs < ActiveRecord::Migration
  def change
    add_column :wcs, :end, :time
  end
end
