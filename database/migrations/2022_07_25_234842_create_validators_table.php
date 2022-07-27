<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

    /*
        array(22) {
    ["discoveredAt"]=>
    int(1594026918348)
    ["nominatedAt"]=>
    int(1600128022421)
    ["offlineSince"]=>
    int(0)
    ["offlineAccumulated"]=>
    int(0)
    ["rank"]=>
    int(23)
    ["faults"]=>
    int(0)
    ["invalidityReasons"]=>
    string(0) ""
    ["unclaimedEras"]=>
    array(0) {
    }
    ["inclusion"]=>
    int(0)
    ["name"]=>
    string(24) "Stake Capital | StakeDAO"
    ["stash"]=>
    string(47) "CsHw8cfzbnKdkCuUq24yuaPyJ1E5a55sNPqejJZ4h7CRtEs"
    ["kusamaStash"]=>
    string(0) ""
    ["commission"]=>
    int(0)
    ["identity"]=>
    array(2) {
      ["name"]=>
      string(25) "Stake Capital | Stake DAO"
      ["_id"]=>
      string(24) "62df2450c4e84c0a1d2a6de5"
    }
    ["active"]=>
    bool(false)
    ["validity"]=> // to separate table
    array(10) {
      [0]=>
      array(5) {
        ["valid"]=>
        bool(true)
        ["type"]=>
        string(17) "UNCLAIMED_REWARDS"
        ["details"]=>
        string(0) ""
        ["updated"]=>
        int(1658761188710)
        ["_id"]=>
        string(24) "62deafe477500d95da3452aa"
      }
      [1]=>
      array(5) {
        ["valid"]=>
        bool(false)
        ["type"]=>
        string(14) "CLIENT_UPGRADE"
        ["details"]=>
        string(60) "Stake Capital | StakeDAO is not on the latest client version"
        ["updated"]=>
        int(1658790201283)
        ["_id"]=>
        string(24) "62df2139c4e84c0a1d27bfe5"
      }
      [2]=>
      array(5) {
        ["valid"]=>
        bool(true)
        ["type"]=>
        string(24) "ACCUMULATED_OFFLINE_TIME"
        ["details"]=>
        string(0) ""
        ["updated"]=>
        int(1658790201305)
        ["_id"]=>
        string(24) "62df2139c4e84c0a1d27c005"
      }
      [3]=>
      array(5) {
        ["valid"]=>
        bool(true)
        ["type"]=>
        string(6) "ONLINE"
        ["details"]=>
        string(0) ""
        ["updated"]=>
        int(1658791307416)
        ["_id"]=>
        string(24) "62df258bc4e84c0a1d2b307f"
      }
      [4]=>
      array(5) {
        ["valid"]=>
        bool(true)
        ["type"]=>
        string(15) "CONNECTION_TIME"
        ["details"]=>
        string(0) ""
        ["updated"]=>
        int(1658791307751)
        ["_id"]=>
        string(24) "62df258bc4e84c0a1d2b30b7"
      }
      [5]=>
      array(5) {
        ["valid"]=>
        bool(false)
        ["type"]=>
        string(8) "IDENTITY"
        ["details"]=>
        string(78) "Stake Capital | StakeDAO has an identity but is not verified by the registrar."
        ["updated"]=>
        int(1658791307774)
        ["_id"]=>
        string(24) "62df258bc4e84c0a1d2b30d3"
      }
      [6]=>
      array(5) {
        ["valid"]=>
        bool(true)
        ["type"]=>
        string(9) "COMMISION"
        ["details"]=>
        string(0) ""
        ["updated"]=>
        int(1658791307790)
        ["_id"]=>
        string(24) "62df258bc4e84c0a1d2b30e4"
      }
      [7]=>
      array(5) {
        ["valid"]=>
        bool(true)
        ["type"]=>
        string(10) "SELF_STAKE"
        ["details"]=>
        string(0) ""
        ["updated"]=>
        int(1658791307836)
        ["_id"]=>
        string(24) "62df258bc4e84c0a1d2b30f4"
      }
      [8]=>
      array(5) {
        ["valid"]=>
        bool(true)
        ["type"]=>
        string(7) "BLOCKED"
        ["details"]=>
        string(0) ""
        ["updated"]=>
        int(1658791307863)
        ["_id"]=>
        string(24) "62df258bc4e84c0a1d2b3104"
      }
      [9]=>
      array(5) {
        ["valid"]=>
        bool(false)
        ["type"]=>
        string(18) "VALIDATE_INTENTION"
        ["details"]=>
        string(60) "Stake Capital | StakeDAO does not have a validate intention."
        ["updated"]=>
        int(1658791676580)
        ["_id"]=>
        string(24) "62df26fcc4e84c0a1d2ca75e"
      }
    }
    ["score"]=> // to separate table
    array(16) {
      ["_id"]=>
      string(24) "60ae23da48b1bf00126c8c5a"
      ["address"]=>
      string(47) "CsHw8cfzbnKdkCuUq24yuaPyJ1E5a55sNPqejJZ4h7CRtEs"
      ["updated"]=>
      int(1622824583711)
      ["total"]=>
      float(120.26458418048036)
      ["aggregate"]=>
      float(119.69971166540434)
      ["inclusion"]=>
      int(5)
      ["spanInclusion"]=>
      int(40)
      ["discovered"]=>
      float(4.126463257761039)
      ["nominated"]=>
      int(35)
      ["rank"]=>
      float(0.5732484076433121)
      ["unclaimed"]=>
      int(15)
      ["bonded"]=>
      int(13)
      ["faults"]=>
      int(5)
      ["offline"]=>
      int(2)
      ["randomness"]=>
      float(1.0047190799979118)
      ["__v"]=>
      int(0)
    }
    ["total"]=>
    float(120.26458418048036)
    ["councilStake"]=>
    string(1) "0"
    ["councilVotes"]=>
    array(0) {
    }
    ["democracyVoteCount"]=>
    int(0)
    ["democracyVotes"]=>
    array(0) {
    }
  }
         */
        Schema::create('validators', function (Blueprint $table) {
            $table->string('id')->primary(); // Stashd validator id
            $table->string('name');
            $table->integer('score');
            $table->integer('rank');
            $table->string('active');
            $table->integer('nomination_order');
            $table->bigInteger('discoveredAt');
            $table->bigInteger('nominatedAt');
            $table->integer('offlineSince');
            $table->integer('offlineAccumulated');
            $table->integer('faults');
            $table->string('invalidityReasons');
            $table->string('unclaimedEras');
            $table->integer('inclusion');
            $table->integer('commission');
            $table->string('identity');
            $table->string('validity');
            $table->string('councilStake');
            $table->string('councilVotes');
            $table->integer('democracyVoteCount');
            $table->string('democracyVotes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('validators');
    }
}
