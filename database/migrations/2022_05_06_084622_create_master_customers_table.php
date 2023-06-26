<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterCustomersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('master_customers', function (Blueprint $table) {
      $table->char('AccrRevAcct', 10);
      $table->char('AccrRevSub', 24);
      $table->char('AcctNbr', 30);
      $table->char('Addr1', 60);
      $table->char('Addr2', 60);
      $table->char('AgentID', 10);
      $table->smallInteger('ApplFinChrg');
      $table->char('ArAcct', 10);
      $table->char('ArSub', 24);
      $table->char('Attn', 30);
      $table->smallInteger('AutoApply');
      $table->char('BankID', 10);
      $table->char('BillAddr1', 60);
      $table->char('BillAddr2', 60);
      $table->char('BillAttn', 30);
      $table->char('BillCity', 30);
      $table->char('BillCountry', 3);
      $table->char('BillFax', 30);
      $table->char('BillName', 60);
      $table->char('BillPhone', 30);
      $table->char('BillSalut', 30);
      $table->char('BillState', 3);
      $table->smallInteger('BillThruProject');
      $table->char('BillZip', 10);
      $table->dateTime('CardExpDate');
      $table->char('CardHldrName', 60);
      $table->char('CardNbr', 20);
      $table->char('CardType', 1);
      $table->char('City', 30);
      $table->char('ClassId', 6);
      $table->smallInteger('ConsolInv');
      $table->char('Country', 3);
      $table->float('CrLmt');
      $table->dateTime('Crtd_DateTime');
      $table->char('Crtd_Prog', 8);
      $table->char('Crtd_User', 10);
      $table->char('CuryId', 4);
      $table->char('CuryPrcLvlRtTp', 6);
      $table->char('CuryRateType', 6);
      $table->smallInteger('CustFillPriority');
      $table->char('CustId', 15);
      $table->char('DfltShipToId', 10);
      $table->char('DocPublishingFlag', 1);
      $table->smallInteger('DunMsg');
      $table->char('EMailAddr', 80);
      $table->char('Fax', 30);
      $table->smallInteger('InvtSubst');
      $table->char('LanguageID', 4);
      $table->dateTime('LUpd_DateTime');
      $table->char('LUpd_Prog', 8);
      $table->char('LUpd_User', 10);
      $table->char('Name', 60);
      $table->integer('NoteId');
      $table->smallInteger('OneDraft');
      $table->char('PerNbr', 6);
      $table->char('Phone', 30);
      $table->char('PmtMethod', 1);
      $table->char('PrcLvlId', 10);
      $table->char('PrePayAcct', 10);
      $table->char('PrePaySub', 24);
      $table->char('PriceClassID', 6);
      $table->smallInteger('PrtMCStmt');
      $table->smallInteger('PrtStmt');
      $table->char('S4Future01', 30);
      $table->char('S4Future02', 30);
      $table->float('S4Future03');
      $table->float('S4Future04');
      $table->float('S4Future05');
      $table->float('S4Future06');
      $table->dateTime('S4Future07');
      $table->dateTime('S4Future08');
      $table->integer('S4Future09');
      $table->integer('S4Future10');
      $table->char('S4Future11', 10);
      $table->char('S4Future12', 10);
      $table->char('Salut', 30);
      $table->dateTime('SetupDate');
      $table->smallInteger('ShipCmplt');
      $table->char('ShipPctAct', 1);
      $table->float('ShipPctMax');
      $table->char('SICCode1', 4);
      $table->char('SICCode2', 4);
      $table->smallInteger('SingleInvoice');
      $table->char('SlsAcct', 10);
      $table->char('SlsperId', 10);
      $table->char('SlsSub', 24);
      $table->char('State', 3);
      $table->char('Status', 1);
      $table->char('StmtCycleId', 2);
      $table->char('StmtType', 1);
      $table->char('TaxDflt', 1);
      $table->char('TaxExemptNbr', 15);
      $table->char('TaxID00', 10);
      $table->char('TaxID01', 10);
      $table->char('TaxID02', 10);
      $table->char('TaxID03', 10);
      $table->char('TaxLocId', 15);
      $table->char('TaxRegNbr', 15);
      $table->char('Terms', 2);
      $table->char('Territory', 10);
      $table->float('TradeDisc');
      $table->char('User1', 30);
      $table->char('User2', 30);
      $table->float('User3');
      $table->float('User4');
      $table->char('User5', 10);
      $table->char('User6', 10);
      $table->dateTime('User7');
      $table->dateTime('User8');
      $table->char('Zip', 10);
      $table->string('Area', 4);
      $table->integer('Branch')->nullable();
      $table->integer('tier')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('master_customers');
  }
}
