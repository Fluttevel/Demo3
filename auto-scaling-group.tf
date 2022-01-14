# =========| AUTO SCALING GROUP |=========

#resource "aws_autoscaling_group" "demo" {
#  launch_configuration = aws_launch_configuration.demo.name
#  vpc_zone_identifier  = [aws_subnet.private-subnet-1.id, aws_subnet.private-subnet-2.id]
#  target_group_arns    = [aws_lb_target_group.asg.arn]
#  health_check_type    = "ELB"
#
#  min_size             = 2
#  max_size             = 10
#
#  tag {
#    key                 = "Name"
#    propagate_at_launch = true
#    value               = "terraform-asg-demo"
#  }
#}