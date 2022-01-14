# =========| PUBLIC SUBNETS |=========

resource "aws_subnet" "public-subnet-1" {
  vpc_id                  = aws_vpc.vpc.id
  cidr_block              = "10.0.10.0/24"
  availability_zone       = "eu-west-2a"
  map_public_ip_on_launch = true

  tags      = {
    Name    = "Public Subnet 1"
  }
}

resource "aws_subnet" "public-subnet-2" {
  vpc_id                  = aws_vpc.vpc.id
  cidr_block              = "10.0.20.0/24"
  availability_zone       = "eu-west-2b"
  map_public_ip_on_launch = true

  tags      = {
    Name    = "Public Subnet 2"
  }
}


# =========| PRIVATE SUBNETS |=========

#resource "aws_subnet" "private" {
#  count = var.az_count
#  vpc_id                  = aws_vpc.vpc.id
#  cidr_block              = cidrsubnet(aws_vpc.vpc.cidr_block, 8, count.index)
#  availability_zone       = "eu-west-2a"
#  map_public_ip_on_launch = false
#
#  tags      = {
#    Name    = "${var.app_name}-${var.environment}-private"
#  }
#}

resource "aws_subnet" "private-subnet-1" {

  vpc_id                  = aws_vpc.vpc.id
  cidr_block              = "10.0.11.0/24"
  availability_zone       = "eu-west-2a"
  map_public_ip_on_launch = false

  tags      = {
    Name    = "Private Subnet 1"
  }
}

resource "aws_subnet" "private-subnet-2" {
  vpc_id                  = aws_vpc.vpc.id
  cidr_block              = "10.0.21.0/24"
  availability_zone       = "eu-west-2b"
  map_public_ip_on_launch = false

  tags      = {
    Name    = "Private Subnet 2"
  }
}