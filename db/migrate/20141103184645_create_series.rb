class CreateSeries < ActiveRecord::Migration
  def change
    create_table :series do |t|
      t.string :matchid
      t.string :name
      t.string :player1
      t.string :player2
      t.integer :player1_score
      t.integer :player2_score
      t.string :start
      t.string :created_at
      t.string :modified_at

      t.timestamps
    end
  end
end
