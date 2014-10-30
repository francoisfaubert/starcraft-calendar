require 'test_helper'

class CalendarControllerTest < ActionController::TestCase
  test "should get sc2" do
    get :sc2
    assert_response :success
  end

end
