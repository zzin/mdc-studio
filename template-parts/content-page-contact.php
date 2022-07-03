<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php get_template_part('template-parts/split/entry', 'header-solid'); ?>
  <div class="container-thin mt-24">
    <h2 class="page-title">Make design <span>Clawesome</span></h2>
    <p class="mt-4 lg:mt-8 lg:word-break-keep-all">
      MDC는 ‘CCC System’ - Custom Care Consulting 시스템과 더불어 최고의 디자인을 만들기 위해 다양한 업종의 기업과 함께하고 있습니다.<br />
      MDC와 같이 가치있는 브랜딩을 만들어보세요.
    </p>
    <form action="" class="form-group" autocomplete="off">
      <h3 class="mt-10 text-lg lg:text-xl font-semibold">의뢰인 정보</h3>
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <div class="input-group">
          <label for="company-name">회사명</label>
          <input type="text" id="company-name" name="company-name" placeholder="회사명을 알려주세요." />
        </div>
        <div class="input-group">
          <label for="company-manager">담당자</label>
          <input type="text" id="company-manager" name="company-manager" placeholder="담당자분 이름을 알려주세요." />
        </div>
        <div class="input-group">
          <label for="company-phone">연락처</label>
          <input type="tel" id="company-phone" name="company-phone" placeholder="연락처를 알려주세요." />
        </div>
        <div class="input-group">
          <label for="company-email">이메일</label>
          <input type="email" id="company-email" name="company-email" placeholder="이메일 주소를 알려주세요." />
        </div>
      </div>
      <h3 class="mt-14 text-lg lg:text-xl font-semibold">의뢰 정보 <small class="font-normal text-black/40">중복 선택 가능</small></h3>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-2 mt-6">
        <div class="checkbox-group">
          <input type="checkbox" name="scope[]" id="bi">
          <label for="bi">Brand Identity <span>/ 브랜드 아이덴티티</span></label>
        </div>
        <div class="checkbox-group">
          <input type="checkbox" name="scope[]" id="ci">
          <label for="ci">Corporate Identity <span>/ 기업 아이덴티티</span></label>
        </div>
        <div class="checkbox-group">
          <input type="checkbox" name="scope[]" id="bs">
          <label for="bs">Brand Story <span>/ 브랜드 스토리</span></label>
        </div>
        <div class="checkbox-group">
          <input type="checkbox" name="scope[]" id="pd">
          <label for="pd">Package Design <span>/ 패키지 디자인</span></label>
        </div>
        <div class="checkbox-group">
          <input type="checkbox" name="scope[]" id="ed">
          <label for="ed">Editorial Design <span>/ 편집 디자인</span></label>
        </div>
        <div class="checkbox-group">
          <input type="checkbox" name="scope[]" id="gd">
          <label for="gd">Graphic Design <span>/ 그래픽 디자인</span></label>
        </div>
      </div>
      <h3 class="mt-14 text-lg lg:text-xl font-semibold">상세 정보</h3>
      <div class="mt-4">
        <div class="textarea-group">
          <textarea name="comment" id="comment" placeholder="상세한 정보를 입력해 주세요."></textarea>
        </div>
      </div>
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <div class="checkbox-group">
          <input type="checkbox" name="agree" id="agree">
          <label for="agree">개인정보 보호정책에 동의</label>
        </div>
        <div class="button-group flex lg:justify-end mt-4 lg:mt-0">
          <button type="submit">SUBMIT FORM</button>
        </div>
      </div>
    </form>
  </div>
</article>