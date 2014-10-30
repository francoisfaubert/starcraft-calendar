class RemoveModifiedAtFromWcs < ActiveRecord::Migration
  def change
    remove_column :wcs, :modified_at
  end
end
